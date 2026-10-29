<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TravelAndToursPageSetting;
use App\Models\TravelAndToursSection;
use Illuminate\View\View;

class TravelAndToursDetailsController extends Controller
{
    public function showTravelAndToursDetails(): View
    {
        $setting = TravelAndToursPageSetting::query()
            ->with('sections')
            ->first() ?? new TravelAndToursPageSetting;
        $travelSections = $setting->sections;

        if (! $setting->exists) {
            $travelSections = collect(TravelAndToursSection::defaultSections())
                ->map(fn (array $section): TravelAndToursSection => new TravelAndToursSection($section));
        }

        return view('travelAndToursDetails', compact('setting', 'travelSections'));
    }
}
