<?php

namespace App\Http\Controllers\restapi;

use App\Enums\DepartmentStatus;
use App\Enums\SymptomStatus;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DepartmentApi extends Controller
{
    public function getList()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($departments);
    }

    public function getBySymptomID($id)
    {
        $symptom = Symptom::find($id);
        if (!$symptom || $symptom->status != SymptomStatus::ACTIVE) {
            return response('Not found!', 404);
        }

        $department = Department::find($symptom->department_id);
        if (!$department || $department->status != DepartmentStatus::ACTIVE) {
            return response('Not found!', 404);
        }

        return response()->json($department);
    }

    public function detail($id)
    {
        $department = Department::find($id);
        if (!$department || $department->status != DepartmentStatus::ACTIVE) {
            return response('Not found!', 404);
        }
        return response()->json($department);
    }

    public function getAllByClinic(Request $request)
    {
        $clinicID = $request->input('clinic_id');
        $clinic = Clinic::find($clinicID);
        if (!$clinic) {
            return response((new MainApi())->returnMessage('Clinic not found'), 404);
        }

        $list_department = $clinic->department;
        $array_department = explode(',', $list_department);
        $departments = Department::whereIn('id', $array_department)->get();
        return response()->json($departments);
    }
}
