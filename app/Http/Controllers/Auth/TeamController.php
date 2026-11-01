<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TeamPageSetting;

class TeamController extends Controller
{
    public function showTeam()
    {
        $setting = TeamPageSetting::query()->with('teamMembers')->first()
            ?? new TeamPageSetting;

        return view('team', compact('setting'));
    }
}
