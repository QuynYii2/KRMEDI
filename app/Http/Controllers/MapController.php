<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function explore() {
        return view('maps.explore');
    }
}
