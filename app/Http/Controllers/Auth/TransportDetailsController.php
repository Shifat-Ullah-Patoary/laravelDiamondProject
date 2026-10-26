<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class TransportDetailsController extends Controller
{
    public function showTransportDetails()
    {
        return view('transportDetails');
    }
}
