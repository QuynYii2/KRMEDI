<?php

namespace App\Http\Controllers;

use App\Models\DoctorInfo;
use Illuminate\Http\Request;

class PharmaciesApiController extends Controller
{
    public function index() {
        $pharmacies = DoctorInfo::where('hocham_hocvi', 'pharmacies')->get();

        return response()->json($pharmacies);
    }

    public function detailPharmacies($id) {
        $detail = DoctorInfo::where([
            'id' => $id,
            'hocham_hocvi' => 'pharmacies'
        ]);

        if (!$detail) {
            return response("Pharmacies not found", 404);
        }

        return response()->json($detail);
    }
}
