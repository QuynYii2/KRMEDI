<?php

namespace App\Http\Controllers;

use App\Enums\TypeMedical;
use App\Models\DoctorInfo;
use Illuminate\Http\Request;

class PharmaciesController extends Controller
{
    public function index() {
        $pharmacies = DoctorInfo::where('hocham_hocvi', TypeMedical::PHAMACISTS)->get();

        return response()->json($pharmacies);
    }

    public function detailPharmacies($id) {
        $detail = DoctorInfo::where([
            'id' => $id,
            'hocham_hocvi' => TypeMedical::PHAMACISTS
        ])->get();

        if (!$detail) {
            return response("Pharmacies not found", 404);
        }

        return response()->json($detail);
    }
}
