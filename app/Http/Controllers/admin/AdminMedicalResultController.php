<?php

namespace App\Http\Controllers\admin;

use App\Enums\MedicalResultStatus;
use App\Http\Controllers\Controller;
use App\Models\MedicalResults;

class AdminMedicalResultController extends Controller
{
    public function list()
    {
        return view('admin.medical-results.list');
    }

    public function detail($id)
    {
        $result = MedicalResults::find($id);
        if (!$result || $result->status == MedicalResultStatus::DELETED){
            alert()->error('Not found!');
            return back();
        }
        $value_result = '[' . $result->result . ']';
        $array_result = json_decode($value_result, true);
        return view('admin.medical-results.detail', compact('result', 'array_result'));
    }

    public function create()
    {
        return view('admin.medical-results.create');
    }
}
