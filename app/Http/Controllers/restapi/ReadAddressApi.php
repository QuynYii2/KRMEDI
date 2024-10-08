<?php

namespace App\Http\Controllers\restapi;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;

class ReadAddressApi extends Controller
{
    public function getAllProvince()
    {
        $provinces = Province::orderBy('name', 'asc')->get();
        return response()->json($provinces);
    }

    public function getAllDistrictByProvinceCode($code)
    {
        $districts = District::where('province_code', $code)->orderBy('name', 'asc')->get();
        return response()->json($districts);
    }

    public function getAllCommuneByDistrictCode($code)
    {
        $communes = Commune::where('district_code', $code)->orderBy('name', 'asc')->get();
        return response()->json($communes);
    }
}
