<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TravelAndToursPageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_travel_settings_are_only_available_to_admins(): void
    {
        $this->get(route('admin.travelDetails-settings.index'))->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user)->get(route('admin.travelDetails-settings.index'))->assertForbidden();

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)
            ->get(route('admin.travelDetails-settings.index'))
            ->assertOk()
            ->assertSee('Add Section')
            ->assertSee('Section 1');
    }

    public function test_admin_can_update_travel_details_shown_on_the_public_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->put(route('admin.travelDetails-settings.update'), [
                'header_badge' => 'Travel Services',
                'header_title_part_1' => 'Updated travel heading',
                'header_title_part_2' => 'Updated highlight',
                'header_description' => 'Updated travel introduction.',
                'header_image' => UploadedFile::fake()->image('travel-header.jpg'),
                'sections' => [[
                    'badge' => 'Custom Tours',
                    'title' => 'Updated travel service',
                    'subtitle' => 'Personalized journeys',
                    'description_1' => 'First travel paragraph.',
                    'description_2' => 'Second travel paragraph.',
                    'image' => UploadedFile::fake()->image('travel-service.jpg'),
                ]],
            ])
            ->assertRedirect(route('admin.travelDetails-settings.index'))
            ->assertSessionHas('success', 'Travel and tours page settings updated successfully.');

        $this->assertDatabaseHas('travel_and_tours_sections', ['title' => 'Updated travel service']);
        $this->get(route('travelAndToursDetals'))
            ->assertOk()
            ->assertSee('Updated travel heading')
            ->assertSee('Updated travel service')
            ->assertSee('storage/travel-and-tours/');
    }

    public function test_invalid_travel_section_image_is_rejected(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from(route('admin.travelDetails-settings.index'))
            ->put(route('admin.travelDetails-settings.update'), [
                'header_title_part_1' => 'Heading',
                'header_title_part_2' => 'Highlight',
                'header_description' => 'Description',
                'sections' => [[
                    'title' => 'Section',
                    'description_1' => 'First',
                    'description_2' => 'Second',
                    'image' => UploadedFile::fake()->create('not-an-image.txt', 10, 'text/plain'),
                ]],
            ])
            ->assertRedirect(route('admin.travelDetails-settings.index'))
            ->assertSessionHasErrors('sections.0.image');

        $this->assertDatabaseCount('travel_and_tours_page_settings', 0);
    }
}
