<?php

namespace Tests\Feature;

use App\Models\TruckDetailsPageSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TruckDetailsPageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_truck_settings_are_only_available_to_admins(): void
    {
        $this->get(route('admin.truckDetails-settings.index'))
            ->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.truckDetails-settings.index'))
            ->assertForbidden();

        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->get(route('admin.truckDetails-settings.index'))
            ->assertOk()
            ->assertSee('Add Vehicle')
            ->assertSee('Vehicle 1')
            ->assertSee('Vehicle 2');
    }

    public function test_admin_can_update_truck_details_shown_on_the_public_page(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['header_description'] = "<script>alert('xss')</script>Dependable vehicle transport.";
        $settings['header_image'] = UploadedFile::fake()->image('header.jpg');
        $settings['vehicles'][0]['image'] = UploadedFile::fake()->image('truck-one.jpg');
        $settings['vehicles'][1]['image'] = UploadedFile::fake()->image('truck-two.jpg');
        $settings['vehicles'][2]['image'] = UploadedFile::fake()->image('truck-three.jpg');

        $this->actingAs($admin)
            ->put(route('admin.truckDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.truckDetails-settings.index'))
            ->assertSessionHas('success', 'Truck details page settings updated successfully.');

        $this->assertDatabaseHas('truck_details_page_settings', [
            'header_title_part_1' => 'Updated transport heading',
        ]);

        $savedSettings = TruckDetailsPageSetting::query()->firstOrFail();
        Storage::disk('public')->assertExists($savedSettings->header_image);
        $savedSections = $savedSettings->vehicleSections()->get();
        $this->assertCount(3, $savedSections);
        $this->assertDatabaseHas('truck_vehicle_sections', [
            'title' => 'Updated third vehicle',
        ]);
        $previousFirstImage = $savedSections[0]->image;
        $removedImage = $savedSections[2]->image;
        Storage::disk('public')->assertExists($savedSections[0]->image);
        Storage::disk('public')->assertExists($savedSections[1]->image);
        Storage::disk('public')->assertExists($removedImage);

        $settings['vehicles'] = [
            ['id' => $savedSections[0]->id] + $this->vehicleSection('Updated first vehicle') + [
                'image' => UploadedFile::fake()->image('replacement-truck.jpg'),
            ],
            ['id' => $savedSections[1]->id] + $this->vehicleSection('Updated second vehicle'),
        ];
        unset($settings['header_image']);
        $this->actingAs($admin)
            ->put(route('admin.truckDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.truckDetails-settings.index'));

        $savedSettings->refresh();
        $savedSections = $savedSettings->vehicleSections()->get();
        $this->assertCount(2, $savedSections);
        Storage::disk('public')->assertMissing($previousFirstImage);
        Storage::disk('public')->assertMissing($removedImage);
        Storage::disk('public')->assertExists($savedSettings->header_image);
        Storage::disk('public')->assertExists($savedSections[0]->image);
        Storage::disk('public')->assertExists($savedSections[1]->image);

        $this->get(route('transportDetails'))
            ->assertOk()
            ->assertSee('Updated transport heading')
            ->assertSee('Updated first vehicle')
            ->assertSee('Updated second vehicle')
            ->assertSee($settings['header_description'])
            ->assertDontSee("<script>alert('xss')</script>", false)
            ->assertSee('storage/'.$savedSettings->header_image)
            ->assertSee('storage/'.$savedSections[0]->image)
            ->assertSee('storage/'.$savedSections[1]->image)
            ->assertDontSee('Updated third vehicle');

        $settings['vehicles'] = [];

        $this->actingAs($admin)
            ->put(route('admin.truckDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.truckDetails-settings.index'));

        $this->assertDatabaseCount('truck_vehicle_sections', 0);

        $this->get(route('transportDetails'))
            ->assertOk()
            ->assertDontSee('vehicle-section-1')
            ->assertDontSee('Updated first vehicle')
            ->assertDontSee('Updated second vehicle');
    }

    public function test_invalid_vehicle_image_is_rejected_without_saving_settings(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['vehicles'][0]['image'] = UploadedFile::fake()->create('not-an-image.txt', 10, 'text/plain');

        $this->actingAs($admin)
            ->from(route('admin.truckDetails-settings.index'))
            ->put(route('admin.truckDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.truckDetails-settings.index'))
            ->assertSessionHasErrors('vehicles.0.image');

        $this->assertDatabaseCount('truck_details_page_settings', 0);
        Storage::disk('public')->assertDirectoryEmpty('truck-details');
    }

    public function test_more_than_twenty_vehicle_sections_are_rejected(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $settings = $this->validSettings();
        $settings['vehicles'] = array_fill(0, 21, $this->vehicleSection('Vehicle'));

        $this->actingAs($admin)
            ->from(route('admin.truckDetails-settings.index'))
            ->put(route('admin.truckDetails-settings.update'), $settings)
            ->assertRedirect(route('admin.truckDetails-settings.index'))
            ->assertSessionHasErrors('vehicles');

        $this->assertDatabaseCount('truck_details_page_settings', 0);
    }

    /**
     * @return array<string, mixed>
     */
    private function validSettings(): array
    {
        return [
            'header_badge' => 'Updated transport badge',
            'header_title_part_1' => 'Updated transport heading',
            'header_title_part_2' => 'Updated heading highlight',
            'header_description' => 'Updated transport introduction.',
            'vehicles' => [
                $this->vehicleSection('Updated first vehicle'),
                $this->vehicleSection('Updated second vehicle'),
                $this->vehicleSection('Updated third vehicle'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function vehicleSection(string $title): array
    {
        return [
            'badge' => 'Truck service',
            'title' => $title,
            'subtitle' => 'Reliable transport service',
            'description_1' => $title.' description one.',
            'description_2' => $title.' description two.',
        ];
    }
}
