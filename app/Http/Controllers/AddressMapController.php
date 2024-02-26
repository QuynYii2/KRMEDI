<?php

namespace App\Http\Controllers;

use App\Models\AddressMap;
use App\Services\GeocodingService;
use Illuminate\Http\Request;

class AddressMapController extends Controller
{
    public function policy()
    {
        return view('policy-krmedi.policy-krmedi');
    }
    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function index()
    {
        $addresses = AddressMap::all();
        $coordinatesArray = $addresses->toArray();
        return view('addresses.index',  compact('coordinatesArray', 'addresses'));
    }

    public function store(Request $request)
    {
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $newAddress = AddressMap::create([
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        if ($newAddress) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
