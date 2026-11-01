<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TeamPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeamPageSettingController extends Controller
{
    public function index(): View
    {
        $setting = TeamPageSetting::query()->with('teamMembers')->first()
            ?? new TeamPageSetting;

        return view('Admin.team-settings', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'section_header_top' => ['required', 'string', 'max:255'],
            'section_header_middle' => ['required', 'string', 'max:255'],
            'section_header_bottom' => ['required', 'string'],
            'founder_header_top' => ['required', 'string', 'max:255'],
            'founder_name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'founder_description' => ['required', 'string'],
            'member_heading' => ['required', 'string', 'max:255'],
            'member_description' => ['required', 'string'],
            'founder_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'members' => ['nullable', 'array'],
            'members.*.id' => ['nullable', 'integer', 'exists:team_members,id'],
            'members.*.name' => ['required', 'string', 'max:255'],
            'members.*.position' => ['required', 'string', 'max:255'],
            'members.*.description' => ['nullable', 'string'],
            'members.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $setting = TeamPageSetting::query()->first() ?? new TeamPageSetting;
        $oldFounderImage = $setting->founder_image;
        $oldMemberImages = $setting->teamMembers()->pluck('image', 'id')->all();
        $founderImage = $request->file('founder_image');
        $members = $validated['members'] ?? [];

        DB::transaction(function () use ($setting, $validated, $founderImage, $members): void {
            $setting->fill(collect($validated)->except(['founder_image', 'members'])->all());

            if ($founderImage) {
                $setting->founder_image = $founderImage->store('team', 'public');
            }

            $setting->save();
            $existingMemberIds = [];

            foreach ($members as $index => $memberData) {
                $member = $setting->teamMembers()->updateOrCreate(
                    ['id' => $memberData['id'] ?? null],
                    [
                        'name' => $memberData['name'],
                        'position' => $memberData['position'],
                        'description' => $memberData['description'] ?? null,
                        'position_order' => $index,
                    ],
                );

                if (! empty($memberData['image'])) {
                    $member->image = $memberData['image']->store('team/members', 'public');
                    $member->save();
                }

                $existingMemberIds[] = $member->id;
            }

            if ($existingMemberIds === []) {
                $setting->teamMembers()->delete();
            } else {
                $setting->teamMembers()->whereNotIn('id', $existingMemberIds)->delete();
            }
        });

        if ($founderImage && $oldFounderImage) {
            Storage::disk('public')->delete($oldFounderImage);
        }

        $currentMemberImages = $setting->teamMembers()->pluck('image')->filter()->all();

        foreach (array_diff($oldMemberImages, $currentMemberImages) as $oldMemberImage) {
            Storage::disk('public')->delete($oldMemberImage);
        }

        return redirect()->route('admin.team-settings.index')
            ->with('success', 'Team page settings updated successfully.');
    }
}
