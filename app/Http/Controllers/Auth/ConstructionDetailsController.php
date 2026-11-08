<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConstructionDetailsPageSetting;
use App\Models\ConstructionServiceSection;
use App\Models\HomePageSetting;
use Illuminate\View\View;

class ConstructionDetailsController extends Controller
{
    public function showConstructionDetails(): View
    {
        $setting = ConstructionDetailsPageSetting::query()
            ->with('serviceSections')
            ->first() ?? new ConstructionDetailsPageSetting;
        $serviceSections = $setting->serviceSections;

        if (! $setting->exists) {
            $serviceSections = collect(ConstructionServiceSection::defaultSections())
                ->map(fn (array $section): ConstructionServiceSection => new ConstructionServiceSection($section));
        }

        $settings =  HomePageSetting::query()->first()
          ?? new  HomePageSetting;

        return view('constructionDetails', compact('setting', 'serviceSections','settings'));
    }
}
