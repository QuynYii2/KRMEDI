<?php

namespace App\Http\Controllers\restapi;

use App\Enums\BookingResultStatus;
use App\Enums\online_medicine\OnlineMedicineStatus;
use App\Http\Controllers\Controller;
use App\Imports\ExcelImportClass;
use App\Models\Booking;
use App\Models\BookingResult;
use App\Models\Clinic;
use App\Models\FamilyManagement;
use App\Models\online_medicine\ProductMedicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BookingResultApi extends Controller
{
    public function getListByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $results = DB::table('booking_results')
            ->where('user_id', $user_id)
            ->where('status', '!=', BookingResultStatus::DELETED)
            ->select('booking_results.*')
            ->orderBy('id', 'desc')
            ->cursor()
            ->map(function ($item) {
                $result = (array)$item;
                $booking = Booking::find($item->booking_id);
                /* Push clinic*/
                $clinic = Clinic::find($booking->clinic_id);
                $result['clinics'] = $clinic->toArray();
                /* Convert date */
                $result['appointment_date'] = $booking->created_at->addHours(7)->format('Y-m-d H:i:s');
                $result['results_date'] = Carbon::parse($item->created_at)->addHours(7)->format('Y-m-d H:i:s');
                /* Push result value */
                $result_value = $item->result;
                $value_result = '[' . $result_value . ']';
                $array_result = json_decode($value_result, true);
                $result['result'] = $array_result;
                $result['result_en'] = $array_result;
                $result['result_laos'] = $array_result;
                /* Fill member family*/
                $member_family = $item->family_member;
                $member_info = null;
                if ($member_family) {
                    $member = FamilyManagement::find($member_family);
                    $member_info = $member->toArray();
                }
                $result['member_info'] = $member_info;
                return $result;
            });

        return response()->json($results);
    }

    public function getProductByPrescriptionsInBookingID($id)
    {
        $result = BookingResult::find($id);
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }
        $file_excel = $result->prescriptions;
        $products = $this->getListProductFromExcel($file_excel);
        return response()->json($products);
    }

    public function getListProductFromExcel($excel_file)
    {
        $excel_file = public_path($excel_file);
        $reader = Excel::toCollection(new ExcelImportClass, $excel_file)->first();
        $nameMedicineArray = [];
        $thanhPhanThuocArray = [];

        foreach ($reader->skip(1) as $row) {
            $nameMedicineArray[] = $row[0];

            $thanhPhanThuocArray[] = explode(',', $row[1]);
        }

        if (count($nameMedicineArray) == 0 && count($thanhPhanThuocArray) == 0) {
            return [];
        }

        $products = ProductMedicine::where(function ($query) use ($nameMedicineArray) {
            foreach ($nameMedicineArray as $nameMedicine) {
                $query->orWhere('name', 'LIKE', '%' . $this->normalizeString($nameMedicine) . '%');
            }
        })
            ->where(function ($query) use ($thanhPhanThuocArray) {
                foreach ($thanhPhanThuocArray as $thanhPhanArray) {
                    $query->orWhere(function ($subQuery) use ($thanhPhanArray) {
                        foreach ($thanhPhanArray as $thanhPhan) {
                            $subQuery->whereHas('DrugIngredient', function ($q) use ($thanhPhan) {
                                $q->where('component_name', 'LIKE', '%' . $this->normalizeString($thanhPhan) . '%');
                            });
                        }
                    });
                }
            })
            ->where('status', OnlineMedicineStatus::APPROVED)
            ->get();
        return $products;
    }

    private function normalizeString($str)
    {
        return strtolower(trim($str));
    }

    public function getListByBusinessID(Request $request)
    {
        $business_id = $request->input('business_id');

        $books = Booking::where('clinic_id', $business_id)->get();
        if (count($books) < 1) {
            return response((new MainApi())->returnMessage('Booking Empty'), 200);
        }

        $array = null;
        foreach ($books as $item) {
            $array[] = $item->id;
        }

        $user_id = $request->input('user_id');
        $results = BookingResult::where('status', BookingResultStatus::ACTIVE)
            ->whereIn('booking_id', $array)
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($results);
    }

    public function detail($id)
    {
        $result = BookingResult::find($id);
        if (!$result || $result->status == BookingResultStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found'), 404);
        }
        $result_value = $result->result;
        $value_result = '[' . $result_value . ']';
        $array_result = json_decode($value_result, true);
        $result->result = $array_result;
        $result->result_en = $array_result;
        $result->result_laos = $array_result;
        return response()->json($result);
    }

    public function delete($id)
    {
        try {
            $result = BookingResult::find($id);
            if (!$result || $result->status == BookingResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found'), 404);
            }
            $result->status = BookingResultStatus::DELETED;
            $success = $result->save();
            if ($success) {
                return response((new MainApi())->returnMessage('Delete success!'), 200);
            }
            return response((new MainApi())->returnMessage('Delete error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }
}
