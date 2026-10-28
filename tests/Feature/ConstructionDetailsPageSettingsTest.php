<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConstructionDetailsPageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_construction_settings_are_only_available_to_admins(): void
    {
        $this->get(route('admin.constructionDetails-settings.index'))
            ->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.constructionDetails-settings.index'))
            ->assertForbidden();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.constructionDetails-settings.index'))
            ->assertOk()
            ->assertSee('Add Service')
            ->assertSee('Service 1');
    }

    public function test_admin_can_update_construction_details_shown_on_the_public_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $settings = [
            'header_badge' => 'Construction Supply',
            'header_title_part_1' => 'Updated construction heading',
            'header_title_part_2' => 'Updated highlight',
            'header_description' => 'Updated construction introduction.',
            'header_image' => UploadedFile::fake()->image('construction-header.jpg'),
            'services' => [
                [
                    'badge' => 'Materials',
                    'title' => 'Updated construction service',
                    'subtitle' => 'Reliable project support',
                    'description_1' => 'First service paragraph.',
                    'description_2' => 'Second service paragraph.',
                    'image' => UploadedFile::fake()->image('construction-service.jpg'),
                ],
            ],
        ];

        $this->actingAs($admin)
            ->put(route('admin.constructionDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.constructionDetails-settings.index'))
            ->assertSessionHas('success', 'Construction details page settings updated successfully.');

        $this->assertDatabaseHas('construction_service_sections', [
            'title' => 'Updated construction service',
        ]);

        $this->get(route('constructionDetails'))
            ->assertOk()
            ->assertSee('Updated construction heading')
            ->assertSee('Updated construction service')
            ->assertSee('storage/construction-details/');
    }

    public function test_invalid_construction_service_image_is_rejected(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from(route('admin.constructionDetails-settings.index'))
            ->put(route('admin.constructionDetails-settings.update'), [
                'header_title_part_1' => 'Heading',
                'header_title_part_2' => 'Highlight',
                'header_description' => 'Description',
                'services' => [[
                    'title' => 'Service',
                    'description_1' => 'First',
                    'description_2' => 'Second',
                    'image' => UploadedFile::fake()->create('not-an-image.txt', 10, 'text/plain'),
                ]],
            ])
            ->assertRedirect(route('admin.constructionDetails-settings.index'))
            ->assertSessionHasErrors('services.0.image');

        $this->assertDatabaseCount('construction_details_page_settings', 0);
    }
}
