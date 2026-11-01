<?php

namespace Tests\Feature;

use App\Models\TeamPageSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamPageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_settings_are_only_available_to_admins(): void
    {
        $this->get(route('admin.team-settings.index'))
            ->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.team-settings.index'))
            ->assertForbidden();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.team-settings.index'))
            ->assertOk()
            ->assertSee('Team Page Settings');
    }

    public function test_admin_can_update_team_settings_shown_on_the_public_page(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['founder_image'] = UploadedFile::fake()->image('founder.jpg');

        $this->actingAs($admin)
            ->put(route('admin.team-settings.update'), $settings)
            ->assertRedirect(route('admin.team-settings.index'))
            ->assertSessionHas('success', 'Team page settings updated successfully.');

        $savedSettings = TeamPageSetting::query()->firstOrFail();
        Storage::disk('public')->assertExists($savedSettings->founder_image);

        $this->get(route('team'))
            ->assertOk()
            ->assertSee($settings['section_header_middle'])
            ->assertSee($settings['founder_name'])
            ->assertSee($settings['member_heading'])
            ->assertSee('storage/'.$savedSettings->founder_image);
    }

    public function test_invalid_founder_image_is_rejected_without_saving_settings(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['founder_image'] = UploadedFile::fake()->create('not-an-image.txt', 10, 'text/plain');

        $this->actingAs($admin)
            ->from(route('admin.team-settings.index'))
            ->put(route('admin.team-settings.update'), $settings)
            ->assertRedirect(route('admin.team-settings.index'))
            ->assertSessionHasErrors('founder_image');

        $this->assertDatabaseCount('team_page_settings', 0);
        Storage::disk('public')->assertDirectoryEmpty('team');
    }

    public function test_admin_can_add_and_remove_team_members(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['members'] = [
            [
                'name' => 'First Member',
                'position' => 'Director',
                'description' => 'First member description.',
                'image' => UploadedFile::fake()->image('first-member.jpg'),
            ],
            [
                'name' => 'Second Member',
                'position' => 'Manager',
                'description' => 'Second member description.',
                'image' => UploadedFile::fake()->image('second-member.jpg'),
            ],
        ];

        $this->actingAs($admin)
            ->put(route('admin.team-settings.update'), $settings)
            ->assertRedirect(route('admin.team-settings.index'));

        $savedSetting = TeamPageSetting::query()->firstOrFail();
        $members = $savedSetting->teamMembers()->get();
        $this->assertCount(2, $members);
        Storage::disk('public')->assertExists($members[0]->image);
        Storage::disk('public')->assertExists($members[1]->image);

        $settings['members'] = [
            ['id' => $members[0]->id] + $settings['members'][0],
        ];

        $this->actingAs($admin)
            ->put(route('admin.team-settings.update'), $settings)
            ->assertRedirect(route('admin.team-settings.index'));

        $this->assertDatabaseCount('team_members', 1);
        $this->assertDatabaseHas('team_members', ['name' => 'First Member']);
        $this->assertDatabaseMissing('team_members', ['name' => 'Second Member']);

        $this->get(route('team'))
            ->assertSee('First Member')
            ->assertDontSee('Second Member');
    }

    /**
     * @return array<string, string>
     */
    private function validSettings(): array
    {
        return [
            'section_header_top' => 'Leadership',
            'section_header_middle' => 'Updated Founder Heading',
            'section_header_bottom' => 'Updated leadership introduction.',
            'founder_header_top' => 'Leadership & Vision',
            'founder_name' => 'Updated Founder',
            'designation' => 'Founder & Chairman',
            'founder_description' => 'Updated founder description.',
            'member_heading' => 'Updated Team Heading',
            'member_description' => 'Updated team description.',
        ];
    }
}
