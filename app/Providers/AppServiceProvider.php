<?php

namespace App\Providers;

use App\Models\FooterSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.footer', function (View $view): void {
            $view->with('footerSettings', FooterSetting::query()->first() ?? new FooterSetting);
        });
    }
}
