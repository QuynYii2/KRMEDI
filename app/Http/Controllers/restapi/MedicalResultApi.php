<?php

namespace App\Http\Controllers\restapi;

use App\Enums\MedicalResultStatus;
use App\Http\Controllers\Controller;
use App\Models\MedicalResults;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalResultApi extends Controller
{
    public function getListByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $results = DB::table('medical_results')
            ->where('user_id', $user_id)
            ->where('status', MedicalResultStatus::APPROVED)
            ->orderBy('id', 'desc')
            ->cursor()
            ->map(function ($item) {
                $result_value = $item->result;
                $datetime = $item->datetime;
                $result = (array)$item;
                $value_result = '[' . $result_value . ']';
                $array_result = json_decode($value_result, true);
                $result['result'] = $array_result;
                $result['datetime'] =  Carbon::parse($datetime)->format('Y-m-d H:i:s');
                $result['result_en'] = $array_result;
                $result['result_laos'] = $array_result;
                return $result;
            });
        return response()->json($results);
    }

    public function getProductByPrescriptionsID($id)
    {
        $result = MedicalResults::find($id);
        if (!$result || $result->status == MedicalResultStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }
        $file_excel = $result->prescriptions;
        $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
        return response()->json($products);
    }

    public function detail($id)
    {
        $result = MedicalResults::find($id);
        if (!$result || $result->status == MedicalResultStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }
        $datetime = $result->datetime;
        $result_value = $result->result;
        $value_result = '[' . $result_value . ']';
        $array_result = json_decode($value_result, true);
        $result->result = $array_result;
        $result->result_en = $array_result;
        $result->result_laos = $array_result;
        $result->datetime =  Carbon::parse($datetime)->format('Y-m-d H:i:s');
        return response()->json($result);
    }
}
