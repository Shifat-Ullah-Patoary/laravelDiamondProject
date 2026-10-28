<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TruckDetailsPageSetting;
use App\Models\TruckVehicleSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class TruckDetailsPageSettingController extends Controller
{
    public function index(): View
    {
        $setting = TruckDetailsPageSetting::query()->first() ?? new TruckDetailsPageSetting;
        $vehicleSections = $setting->vehicleSections;

        if (! $setting->exists) {
            $vehicleSections = collect(TruckVehicleSection::defaultSections())
                ->map(fn (array $section): TruckVehicleSection => new TruckVehicleSection($section));
        }

        return view('Admin.truckDetails-settings', compact('setting', 'vehicleSections'));
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = TruckDetailsPageSetting::query()->firstOrNew();
        $existingSections = $setting->exists
            ? $setting->vehicleSections()->get()->keyBy('id')
            : collect();

        $validated = $request->validate([
            'header_badge' => ['nullable', 'string', 'max:255'],
            'header_title_part_1' => ['required', 'string', 'max:255'],
            'header_title_part_2' => ['required', 'string', 'max:255'],
            'header_description' => ['required', 'string', 'max:10000'],
            'header_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'vehicles' => ['sometimes', 'array', 'max:20'],
            'vehicles.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::in($existingSections->keys()->all()),
            ],
            'vehicles.*.badge' => ['nullable', 'string', 'max:255'],
            'vehicles.*.title' => ['required', 'string', 'max:255'],
            'vehicles.*.subtitle' => ['nullable', 'string', 'max:255'],
            'vehicles.*.description_1' => ['required', 'string', 'max:10000'],
            'vehicles.*.description_2' => ['required', 'string', 'max:10000'],
            'vehicles.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $newImagePaths = [];
        $headerImagePath = null;
        $vehicleImagePaths = [];

        if ($request->hasFile('header_image')) {
            $headerImagePath = $this->storeImage($request->file('header_image'));
            $newImagePaths[] = $headerImagePath;
        }

        foreach (array_keys($validated['vehicles'] ?? []) as $index) {
            $image = $request->file("vehicles.{$index}.image");

            if ($image instanceof UploadedFile) {
                $vehicleImagePaths[$index] = $this->storeImage($image);
                $newImagePaths[] = $vehicleImagePaths[$index];
            }
        }

        $previousImages = [];

        try {
            DB::transaction(function () use (
                $setting,
                $validated,
                $headerImagePath,
                $existingSections,
                $vehicleImagePaths,
                &$previousImages,
            ): void {
                $setting->fill(Arr::only($validated, [
                    'header_badge',
                    'header_title_part_1',
                    'header_title_part_2',
                    'header_description',
                ]));

                if ($headerImagePath !== null) {
                    if ($setting->header_image) {
                        $previousImages[] = $setting->header_image;
                    }

                    $setting->header_image = $headerImagePath;
                }

                $setting->save();
                $submittedSectionIds = [];
                $position = 0;

                foreach ($validated['vehicles'] ?? [] as $index => $vehicleData) {
                    $sectionId = $vehicleData['id'] ?? null;
                    $section = $sectionId === null
                        ? new TruckVehicleSection
                        : $existingSections->get((int) $sectionId);

                    if (! $section instanceof TruckVehicleSection) {
                        throw new RuntimeException('The submitted vehicle section could not be found.');
                    }

                    if ($section->image && isset($vehicleImagePaths[$index])) {
                        $previousImages[] = $section->image;
                    }

                    $section->fill(Arr::only($vehicleData, [
                        'badge',
                        'title',
                        'subtitle',
                        'description_1',
                        'description_2',
                    ]));
                    $section->position = $position++;
                    $section->truckDetailsPageSetting()->associate($setting);

                    if (isset($vehicleImagePaths[$index])) {
                        $section->image = $vehicleImagePaths[$index];
                    }

                    $section->save();
                    $submittedSectionIds[] = $section->id;
                }

                foreach ($existingSections as $existingSection) {
                    if (! in_array($existingSection->id, $submittedSectionIds, true)) {
                        if ($existingSection->image) {
                            $previousImages[] = $existingSection->image;
                        }

                        $existingSection->delete();
                    }
                }
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($newImagePaths);

            throw $exception;
        }

        Storage::disk('public')->delete(array_unique($previousImages));

        return redirect()
            ->route('admin.truckDetails-settings.index')
            ->with('success', 'Truck details page settings updated successfully.');
    }

    private function storeImage(UploadedFile $image): string
    {
        $imagePath = $image->store('truck-details', 'public');

        if (! is_string($imagePath)) {
            throw new RuntimeException('Unable to store the uploaded vehicle image.');
        }

        return $imagePath;
    }
}
