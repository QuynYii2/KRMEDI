<?php

namespace App\Http\Controllers;

use App\Enums\MedicalResultStatus;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Models\MedicalResults;

class MedicalResultController extends Controller
{
    public function list()
    {
        return view('ui.medical-result.list');
    }

    public function detail($id)
    {
        $result = MedicalResults::find($id);
        if (!$result || $result->status == MedicalResultStatus::DELETED) {
            alert()->error('Not found!');
            return back();
        }
        $value_result = '[' . $result->result . ']';
        $array_result = json_decode($value_result, true);

        $products = null;
        if ($result->prescriptions) {
            $products = (new BookingResultApi())->getListProductFromExcel($result->prescriptions);
        }
        return view('ui.medical-result.detail', compact('result', 'array_result', 'products'));
    }
}
