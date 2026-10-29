<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TravelAndToursPageSetting;
use App\Models\TravelAndToursSection;
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

class TravelAndToursPageSettingController extends Controller
{
    public function index(): View
    {
        $setting = TravelAndToursPageSetting::query()->first() ?? new TravelAndToursPageSetting;
        $sections = $setting->sections;

        if (! $setting->exists) {
            $sections = collect(TravelAndToursSection::defaultSections())
                ->map(fn (array $section): TravelAndToursSection => new TravelAndToursSection($section));
        }

        return view('Admin.travelAndTours-settings', compact('setting', 'sections'));
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = TravelAndToursPageSetting::query()->firstOrNew();
        $existingSections = $setting->exists
            ? $setting->sections()->get()->keyBy('id')
            : collect();

        $validated = $request->validate([
            'header_badge' => ['nullable', 'string', 'max:255'],
            'header_title_part_1' => ['required', 'string', 'max:255'],
            'header_title_part_2' => ['required', 'string', 'max:255'],
            'header_description' => ['required', 'string', 'max:10000'],
            'header_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sections' => ['sometimes', 'array', 'max:20'],
            'sections.*.id' => ['nullable', 'integer', 'distinct', Rule::in($existingSections->keys()->all())],
            'sections.*.badge' => ['nullable', 'string', 'max:255'],
            'sections.*.title' => ['required', 'string', 'max:255'],
            'sections.*.subtitle' => ['nullable', 'string', 'max:255'],
            'sections.*.description_1' => ['required', 'string', 'max:10000'],
            'sections.*.description_2' => ['required', 'string', 'max:10000'],
            'sections.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $newImagePaths = [];
        $headerImagePath = null;
        $sectionImagePaths = [];

        if ($request->hasFile('header_image')) {
            $headerImagePath = $this->storeImage($request->file('header_image'));
            $newImagePaths[] = $headerImagePath;
        }

        foreach (array_keys($validated['sections'] ?? []) as $index) {
            $image = $request->file("sections.{$index}.image");

            if ($image instanceof UploadedFile) {
                $sectionImagePaths[$index] = $this->storeImage($image);
                $newImagePaths[] = $sectionImagePaths[$index];
            }
        }

        $previousImages = [];

        try {
            DB::transaction(function () use ($setting, $validated, $headerImagePath, $existingSections, $sectionImagePaths, &$previousImages): void {
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

                foreach ($validated['sections'] ?? [] as $index => $sectionData) {
                    $sectionId = $sectionData['id'] ?? null;
                    $section = $sectionId === null
                        ? new TravelAndToursSection
                        : $existingSections->get((int) $sectionId);

                    if (! $section instanceof TravelAndToursSection) {
                        throw new RuntimeException('The submitted travel section could not be found.');
                    }

                    if ($section->image && isset($sectionImagePaths[$index])) {
                        $previousImages[] = $section->image;
                    }

                    $section->fill(Arr::only($sectionData, [
                        'badge',
                        'title',
                        'subtitle',
                        'description_1',
                        'description_2',
                    ]));
                    $section->position = $position++;
                    $section->travelAndToursPageSetting()->associate($setting);

                    if (isset($sectionImagePaths[$index])) {
                        $section->image = $sectionImagePaths[$index];
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
            ->route('admin.travelDetails-settings.index')
            ->with('success', 'Travel and tours page settings updated successfully.');
    }

    private function storeImage(UploadedFile $image): string
    {
        $imagePath = $image->store('travel-and-tours', 'public');

        if (! is_string($imagePath)) {
            throw new RuntimeException('Unable to store the uploaded travel image.');
        }

        return $imagePath;
    }
}
