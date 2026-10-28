<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConstructionDetailsPageSetting;
use App\Models\ConstructionServiceSection;
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

class ConstructionDetailsPageSettingController extends Controller
{
    public function index(): View
    {
        $setting = ConstructionDetailsPageSetting::query()->first() ?? new ConstructionDetailsPageSetting;
        $serviceSections = $setting->serviceSections;

        if (! $setting->exists) {
            $serviceSections = collect(ConstructionServiceSection::defaultSections())
                ->map(fn (array $section): ConstructionServiceSection => new ConstructionServiceSection($section));
        }

        return view('Admin.constructionDetails-settings', compact('setting', 'serviceSections'));
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = ConstructionDetailsPageSetting::query()->firstOrNew();
        $existingSections = $setting->exists
            ? $setting->serviceSections()->get()->keyBy('id')
            : collect();

        $validated = $request->validate([
            'header_badge' => ['nullable', 'string', 'max:255'],
            'header_title_part_1' => ['required', 'string', 'max:255'],
            'header_title_part_2' => ['required', 'string', 'max:255'],
            'header_description' => ['required', 'string', 'max:10000'],
            'header_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'services' => ['sometimes', 'array', 'max:20'],
            'services.*.id' => [
                'nullable',
                'integer',
                'distinct',
                Rule::in($existingSections->keys()->all()),
            ],
            'services.*.badge' => ['nullable', 'string', 'max:255'],
            'services.*.title' => ['required', 'string', 'max:255'],
            'services.*.subtitle' => ['nullable', 'string', 'max:255'],
            'services.*.description_1' => ['required', 'string', 'max:10000'],
            'services.*.description_2' => ['required', 'string', 'max:10000'],
            'services.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $newImagePaths = [];
        $headerImagePath = null;
        $serviceImagePaths = [];

        if ($request->hasFile('header_image')) {
            $headerImagePath = $this->storeImage($request->file('header_image'));
            $newImagePaths[] = $headerImagePath;
        }

        foreach (array_keys($validated['services'] ?? []) as $index) {
            $image = $request->file("services.{$index}.image");

            if ($image instanceof UploadedFile) {
                $serviceImagePaths[$index] = $this->storeImage($image);
                $newImagePaths[] = $serviceImagePaths[$index];
            }
        }

        $previousImages = [];

        try {
            DB::transaction(function () use (
                $setting,
                $validated,
                $headerImagePath,
                $existingSections,
                $serviceImagePaths,
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

                foreach ($validated['services'] ?? [] as $index => $serviceData) {
                    $sectionId = $serviceData['id'] ?? null;
                    $section = $sectionId === null
                        ? new ConstructionServiceSection
                        : $existingSections->get((int) $sectionId);

                    if (! $section instanceof ConstructionServiceSection) {
                        throw new RuntimeException('The submitted construction service section could not be found.');
                    }

                    if ($section->image && isset($serviceImagePaths[$index])) {
                        $previousImages[] = $section->image;
                    }

                    $section->fill(Arr::only($serviceData, [
                        'badge',
                        'title',
                        'subtitle',
                        'description_1',
                        'description_2',
                    ]));
                    $section->position = $position++;
                    $section->constructionDetailsPageSetting()->associate($setting);

                    if (isset($serviceImagePaths[$index])) {
                        $section->image = $serviceImagePaths[$index];
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
            ->route('admin.constructionDetails-settings.index')
            ->with('success', 'Construction details page settings updated successfully.');
    }

    private function storeImage(UploadedFile $image): string
    {
        $imagePath = $image->store('construction-details', 'public');

        if (! is_string($imagePath)) {
            throw new RuntimeException('Unable to store the uploaded construction image.');
        }

        return $imagePath;
    }
}
