<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\MedicalResultStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Controllers\restapi\BookingResultApi;
use App\Http\Controllers\restapi\MainApi;
use App\Models\MedicalResults;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMedicalResultApi extends Controller
{
    public function getList(Request $request)
    {
        $user_id = $request->input('user_id');
        $isAdmin = (new MainApi())->isAdmin($user_id);
        if ($isAdmin) {
            $results = MedicalResults::where('status', '!=', MedicalResultStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $results = MedicalResults::where('created_by', $user_id)
                ->where('status', '!=', MedicalResultStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($results);
    }

    public function getListByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $status = $request->input('status');
        if ($status) {
            $results = MedicalResults::where('user_id', $user_id)
                ->where('status', $status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $results = MedicalResults::where('user_id', $user_id)
                ->where('status', '!=', MedicalResultStatus::DELETED)
                ->orderBy('id', 'desc')
                ->get();
        }
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
        $result_value = $result->result;
        $value_result = '[' . $result_value . ']';
        $array_result = json_decode($value_result, true);
        $result->result = $array_result;
        $result->result_en = $array_result;
        $result->result_laos = $array_result;
        return response()->json($result);
    }

    public function create(Request $request)
    {
        try {
            $result = new MedicalResults();
            $array = $this->save($request, $result);
            if ($array['status'] == 200) {
                $result = $array['data'];
                $success = $result->save();
                if ($success) {
                    return response()->json($array['data']);
                }
                return response((new MainApi())->returnMessage('Create error!'), 400);
            }
            return response((new MainApi())->returnMessage($array['data']), $array['status']);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }

    private function save($request, $result)
    {
        $service_name = $request->input('service_result');

        $full_name = $request->input('full_name');
        $phone = $request->input('phone');
        $address = $request->input('address');

        $place = $request->input('place');
        $datetime = $request->input('datetime');

        $code = $request->input('code');
        if (!$code) {
            $code = 'MR' . (new MainController())->generateRandomString(8);
        }

        $user = User::where('phone', $phone)->first();
        if (!$user || $user->status == UserStatus::DELETED) {
            return $this->returnArray('400', 'User not found, Please check your registered phone number again!!!');
        }

        $result_input = $request->input('result');
        $result_input_en = $request->input('result_en');
        $result_input_laos = $request->input('result_laos');

        $detail = $request->input('detail');
        $detail_en = $request->input('detail_en');
        $detail_laos = $request->input('detail_laos');

        $user_id = $user->id;
        $email = $user->email;

        $created_by = $request->input('created_by');
        $status = $request->input('status');
        if (!$status) {
            $status = MedicalResultStatus::APPROVED;
        }

        if ($request->hasFile('files')) {
            $galleryPaths = array_map(function ($image) {
                $itemPath = $image->store('medical_result', 'public');
                return asset('storage/' . $itemPath);
            }, $request->file('files'));
            $files = implode(',', $galleryPaths);
            $result->files = $files;
        }

        if ($request->hasFile('prescriptions')) {
            $item = $request->file('prescriptions');
            $itemPath = $item->store('medical_result', 'public');
            $file = asset('storage/' . $itemPath);
            $result->prescriptions = $file;
        }

        $result->service_name = $service_name;

        $result->code = $code;

        $result->result = $result_input;
        $result->result_en = $result_input_en;
        $result->result_laos = $result_input_laos;

        $result->detail = $detail;
        $result->detail_en = $detail_en;
        $result->detail_laos = $detail_laos;

        $result->place = $place;
        $result->datetime = $datetime;

        $result->full_name = $full_name;
        $result->phone = $phone;
        $result->address = $address;

        $result->user_id = $user_id;
        $result->email = $email;

        $result->created_by = $created_by;

        $result->status = $status;
        return $this->returnArray('200', $result);
    }

    private function returnArray($status, $data)
    {
        $myArray['status'] = $status;
        $myArray['data'] = $data;
        return $myArray;
    }

    public function update($id, Request $request)
    {
        try {
            $result = MedicalResults::find($id);
            if (!$result || $result->status == MedicalResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found'), 404);
            }

            $array = $this->save($request, $result);
            if ($array['status'] == 200) {
                $result = $array['data'];
                $success = $result->save();
                if ($success) {
                    return response()->json($array['data']);
                }
                return response((new MainApi())->returnMessage('Update error!'), 400);
            }
            return response((new MainApi())->returnMessage($array['data']), $array['status']);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }

    public function delete($id)
    {
        try {
            $result = MedicalResults::find($id);
            if (!$result || $result->status == MedicalResultStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found'), 404);
            }
            $result->status = MedicalResultStatus::DELETED;
            $success = $result->save();
            if ($success) {
                return response((new MainApi())->returnMessage('Delete success!'), 200);
            }
            return response((new MainApi())->returnMessage('Delete error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }
}
