<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\TypeBussiness;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicApi extends Controller
{
    public function getAll()
    {
        $clinics = Clinic::where('status', ClinicStatus::ACTIVE)->where('type', TypeBussiness::CLINICS)->get();
        return response()->json($clinics);
    }

    public function detail($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic || $clinic->status != ClinicStatus::ACTIVE) {
            return response("Clinic not found", 404);
        }
        return response()->json($clinic);
    }

    public function getAllByUserId($id)
    {
        $clinics = Clinic::where([
            ['status', ClinicStatus::ACTIVE],
            ['type', TypeBussiness::CLINICS],
            ['user_id', $id]
        ])->get();
        return response()->json($clinics);
    }
}
