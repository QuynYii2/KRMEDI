<?php

namespace App\Http\Controllers\restapi;

use App\Enums\SymptomStatus;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Symptom;

class SymptomsApi extends Controller
{
    public function getList()
    {
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($symptoms);
    }

    public function getListByDepartment($id)
    {
        $symptoms = Symptom::where('status', SymptomStatus::ACTIVE)
            ->where('department_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        $department = Department::find($id);
        $data = [
            'department' => $department->toArray(),
            'total_symptoms' => count($symptoms),
            'list_symptoms' => $symptoms->toArray(),
        ];
        $response = [
            'code' => 200,
            'message' => 'Success',
            'data' => $data
        ];
        return response()->json($response);
    }

    public function detail($id)
    {
        $symptom = Symptom::find($id);
        if (!$symptom || $symptom->status != SymptomStatus::ACTIVE) {
            return response('Not found!', 404);
        }
        return response()->json($symptom);
    }
}
