<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\HomePageSetting;

class IndexController extends Controller
{
    public function showIndex()
    {
        $settings = HomePageSetting::query()->first();

        return view('index', compact('settings'));
    }

    
}
