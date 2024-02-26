<?php

namespace App\Http\Controllers\restapi;

use App\Enums\DoctorDepartmentStatus;
use App\Http\Controllers\Controller;
use App\Models\DoctorDepartment;

class DoctorDepartmentApi extends Controller
{
    public function getAll()
    {
        $departments = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)->get();
        return response()->json($departments);
    }

    public function getAllByUserID($id)
    {
        $departments = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)
            ->where('user_id', $id)
            ->get();
        return response()->json($departments);
    }

    public function getById($id)
    {
        $department = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)
            ->where('id', $id)
            ->first();
        if (!$department) {
            return response('Not found!', 404);
        }
        return response()->json($department);
    }
}
