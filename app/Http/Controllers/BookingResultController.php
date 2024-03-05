<?php

namespace App\Http\Controllers;

use App\Enums\BookingResultStatus;
use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Http\Controllers\restapi\MainApi;
use App\Models\BookingResult;
use App\Models\ServiceClinic;
use Illuminate\Support\Facades\Auth;

class BookingResultController extends Controller
{
    public function getList($id)
    {
        $isAdmin = (new MainController())->checkAdmin();
        if ($isAdmin) {
            $results = BookingResult::where('status', '!=', BookingResultStatus::DELETED)
                ->orderBy('id', 'desc')
                ->where('booking_id', $id)
                ->get();
        } else {
            $results = BookingResult::where('status', '!=', BookingResultStatus::DELETED)
                ->orderBy('id', 'desc')
                ->where('booking_id', $id)
                ->where('user_id', Auth::user()->id)
                ->get();
        }
        return view('admin.booking.list-result', compact('results'));
    }

    public function detail($id)
    {
        $result = BookingResult::find($id);
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            return back();
        }

        $value_result = '[' . $result->result . ']';
        $array_result = json_decode($value_result, true);
        return view('admin.booking.detail-booking-result', compact('result',  'array_result'));
    }

    public function getListProduct($id)
    {
        $result = BookingResult::find($id);
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }

        $file_excel = $result->prescriptions;
        $products = [];
        if ($file_excel){
            $products = (new BookingResultApi())->getListProductFromExcel($file_excel);
        }
        return view('admin.booking.list-products', compact('products'));
    }
}
