<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DoctorInfoStatus;
use App\Enums\TypeMedical;
use App\Http\Controllers\Controller;
use App\Models\DoctorInfo;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPhamacitisApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $doctor_infos = User::where('status', $status)
                ->where('member', TypeMedical::PHAMACISTS)
                ->get();
        } else {
            $doctor_infos = User::where('status', '!=', DoctorInfoStatus::DELETED)
                ->where('member', TypeMedical::PHAMACISTS)
                ->get();
        }
        return response()->json($doctor_infos);
    }

    public function search(Request $request)
    {

    }

    public function findByUser($id)
    {
        $doctor_infos = DoctorInfo::where('created_by', $id)
            ->where('hocham_hocvi', TypeMedical::PHAMACISTS)
            ->first();
        if (!$doctor_infos || $doctor_infos->status == DoctorInfoStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($doctor_infos);
    }

    public function detail(Request $request, $id)
    {
        $doctor_infos = DoctorInfo::where('id', $id)
            ->where('hocham_hocvi', TypeMedical::PHAMACISTS)
            ->first();
        if (!$doctor_infos || $doctor_infos->status == DoctorInfoStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($doctor_infos);
    }
}
