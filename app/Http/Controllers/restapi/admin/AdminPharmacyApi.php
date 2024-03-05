<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\ClinicStatus;
use App\Enums\TypeBusiness;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminPharmacyApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status && $status != ClinicStatus::DELETED) {
            $pharmacies = Clinic::where('status', $status)
                ->where('type', TypeBusiness::PHARMACIES)
                ->get();
        } else {
            $pharmacies = Clinic::where('status', '!=', ClinicStatus::DELETED)
                ->where('type', TypeBusiness::PHARMACIES)
                ->get();
        }
        return response()->json($pharmacies);
    }

    public function getAllPharmacy(Request $request)
    {

        $status = $request->input('status');
        if ($status && $status != ClinicStatus::DELETED) {
            $pharmacy = Clinic::where('status', $status)
                ->where('type', TypeBusiness::PHARMACIES)
                ->get();
        } else {
            $pharmacy = Clinic::where('status', '!=', ClinicStatus::DELETED)
                ->where('type', TypeBusiness::PHARMACIES)
                ->get();
        }

        return response()->json($pharmacy);
    }

    public function getAllByUserId(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status && $status != ClinicStatus::DELETED) {
            $pharmacies = Clinic::where([
                ['status', $status],
                ['user_id', $id]
            ])->where('type', TypeBusiness::PHARMACIES)->get();
        } else {
            $pharmacies = Clinic::where([
                ['status', '!=', ClinicStatus::DELETED],
                ['user_id', $id]
            ])->where('type', TypeBusiness::PHARMACIES)->get();
        }
        return response()->json($pharmacies);
    }

    public function create(Request $request)
    {
        try {
            $pharmacy = new Clinic();

            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $name_en = $request->input('name_en');
            $name_laos = $request->input('name_laos');
            $address_detail = $request->input('address_detail');
            $address_detail_en = $request->input('address_detail_en');
            $user_id = $request->input('user_id');
            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $open_date = $request->input('open_date');
            $close_date = $request->input('close_date');
            $introduce = $request->input('introduce');

            $department = $request->input('departments');
            $symptoms = $request->input('symptoms');

            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            } else {
                $gallery = '';
            }

            $status = $request->input('status');

            $pharmacy->name = $name;
            $pharmacy->phone = $phone;
            $pharmacy->email = $email;
            $pharmacy->name_en = $name_en ?? '';
            $pharmacy->name_laos = $name_laos ?? '';
            $pharmacy->address_detail = $address_detail;
            $pharmacy->address_detail_en = $address_detail_en ?? '';
            $pharmacy->user_id = $user_id;
            $pharmacy->type = TypeBusiness::PHARMACIES;

            $address = [
                'nation_id' => $nation_id,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'commune_id' => $commune_id
            ];

            $pharmacy->address = implode(',', $address);

            $pharmacy->open_date = $open_date ?? Carbon::now()->addHours(7);
            $pharmacy->close_date = $close_date ?? Carbon::now()->addHours(7)->addDay();
            $pharmacy->introduce = $introduce;
            $pharmacy->gallery = $gallery;
            $pharmacy->status = $status ?? ClinicStatus::ACTIVE;

            $pharmacy->department = $department;
            $pharmacy->symptom = $symptoms;

            if (!$user_id) {
                return response("UserID not null!", 400);
            } else {
                $user = User::find($user_id);
                if (!$user || $user->status == UserStatus::DELETED || $user->status == UserStatus::BLOCKED) {
                    return response("User not found!", 400);
                }
            }

            $success = $pharmacy->save();
            if ($success) {
                return response()->json($pharmacy);
            }
            return response("Error, Please try again!", 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function detail($id)
    {
        $pharmacy = Clinic::find($id);
        if (!$pharmacy || $pharmacy->status == ClinicStatus::DELETED) {
            return response("Clinic not found", 404);
        }
        return response()->json($pharmacy);
    }

    public function update($id, Request $request)
    {
        try {
            $pharmacy = Clinic::find($id);
            if (!$pharmacy || $pharmacy->status == ClinicStatus::DELETED) {
                return response("Clinic not found", 404);
            }

            $name = $request->input('name') ?? $pharmacy->name;
            $phone = $request->input('phone') ?? $pharmacy->phone;
            $email = $request->input('email') ?? $pharmacy->email;
            $name_en = $request->input('name_en') ?? $pharmacy->name_en;
            $name_laos = $request->input('name_laos') ?? $pharmacy->name_en;
            $address_detail = $request->input('address_detail') ?? $pharmacy->address_detail;
            $address_detail_en = $request->input('address_detail_en') ?? $pharmacy->address_detail_en;
            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $open_date = $request->input('open_date') ?? $pharmacy->open_date;
            $close_date = $request->input('close_date') ?? $pharmacy->close_date;
            $introduce = $request->input('introduce') ?? $pharmacy->introduce;
            $status = $request->input('status') ?? $pharmacy->status;

            $department = $request->input('departments') ?? $pharmacy->department;;
            $symptoms = $request->input('symptoms') ?? $pharmacy->symptom;;

            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            } else {
                $gallery = $pharmacy->gallery;
            }

            $pharmacy->name = $name;
            $pharmacy->phone = $phone;
            $pharmacy->email = $email;
            $pharmacy->name_en = $name_en ?? '';
            $pharmacy->name_laos = $name_laos ?? '';
            $pharmacy->address_detail = $address_detail;
            $pharmacy->address_detail_en = $address_detail_en ?? '';

            $address = [
                'nation_id' => $nation_id,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'commune_id' => $commune_id
            ];

            $pharmacy->address = implode(',', $address);

            $pharmacy->open_date = $open_date ?? Carbon::now()->addHours(7);
            $pharmacy->close_date = $close_date ?? Carbon::now()->addHours(7)->addDay();
            $pharmacy->introduce = $introduce;
            $pharmacy->gallery = $gallery;
            $pharmacy->status = $status ?? ClinicStatus::ACTIVE;

            $pharmacy->department = $department;
            $pharmacy->symptom = $symptoms;

            $success = $pharmacy->save();
            if ($success) {
                return response()->json($pharmacy);
            }
            return response("Error, Please try again!", 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $pharmacy = Clinic::find($id);
            if (!$pharmacy || $pharmacy->status == ClinicStatus::DELETED) {
                return response("Clinic not found", 404);
            }
            $pharmacy->status = ClinicStatus::DELETED;
            $success = $pharmacy->save();
            if ($success) {
                return response("Delete success!", 200);
            }
            return response("Error, Please try again!", 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
