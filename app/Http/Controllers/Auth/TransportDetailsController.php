<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TruckDetailsPageSetting;
use App\Models\TruckVehicleSection;
use Illuminate\View\View;

class TransportDetailsController extends Controller
{
    public function showTransportDetails(): View
    {
        $setting = TruckDetailsPageSetting::query()
            ->with('vehicleSections')
            ->first() ?? new TruckDetailsPageSetting;
        $vehicleSections = $setting->vehicleSections;

        if (! $setting->exists) {
            $vehicleSections = collect(TruckVehicleSection::defaultSections())
                ->map(fn (array $section): TruckVehicleSection => new TruckVehicleSection($section));
        }

        return view('transportDetails', compact('setting', 'vehicleSections'));
    }
}
