<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_footer_settings_are_only_available_to_admins(): void
    {
        $this->get(route('admin.footer-settings.index'))
            ->assertRedirect(route('login'));

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.footer-settings.index'))
            ->assertForbidden();
    }

    public function test_admin_can_update_footer_content_and_social_links(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->put(route('admin.footer-settings.update'), [
                'title' => 'Updated Diamond Group',
                'description' => 'A new footer description.',
                'facebook_url' => 'https://facebook.com/diamond',
                'instagram_url' => 'https://instagram.com/diamond',
                'linkedin_url' => 'https://linkedin.com/company/diamond',
                'whatsapp_url' => 'https://wa.me/8801700000000',
            ])
            ->assertRedirect(route('admin.footer-settings.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('footer_settings', [
            'title' => 'Updated Diamond Group',
            'description' => 'A new footer description.',
            'facebook_url' => 'https://facebook.com/diamond',
            'instagram_url' => 'https://instagram.com/diamond',
            'linkedin_url' => 'https://linkedin.com/company/diamond',
            'whatsapp_url' => 'https://wa.me/8801700000000',
        ]);

        $this->get(route('index'))
            ->assertOk()
            ->assertSee('Updated Diamond Group')
            ->assertSee('A new footer description.')
            ->assertSee('https://facebook.com/diamond');
    }

    public function test_social_links_must_be_valid_urls(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->from(route('admin.footer-settings.index'))
            ->put(route('admin.footer-settings.update'), [
                'title' => 'Diamond Group',
                'facebook_url' => 'not-a-url',
            ])
            ->assertRedirect(route('admin.footer-settings.index'))
            ->assertSessionHasErrors('facebook_url');

        $this->assertDatabaseCount('footer_settings', 0);
    }
}
