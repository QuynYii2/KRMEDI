<?php

namespace App\Http\Controllers\restapi\ui;

use App\Enums\ClinicStatus;
use App\Enums\Role;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Clinic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MyBusinessApi extends Controller
{
    public function updateBusiness(Request $request)
    {
        try {
            $data = (new MainApi())->handleToken();
            if ($data['status'] == 200) {
                $user = $data['data'];

                if (!$user || $user->status == UserStatus::DELETED) {
                    return response((new MainApi())->returnMessage('User not found!'), 404);
                }

                if ($user->type != Role::BUSINESS) {
                    return response((new MainApi())->returnMessage('User not a business activity!'), 400);
                }

                $clinic = Clinic::where('user_id', $user->id)->first();

                $name = $request->input('name') ?? $clinic->name;
                $name_en = $request->input('name_en') ?? $clinic->name_en;
                $name_laos = $request->input('name_laos') ?? $clinic->name_laos;
                $phone = $request->input('phone') ?? $clinic->phone;
                $email = $request->input('email') ?? $clinic->email;
                $address_detail = $request->input('address_detail') ?? $clinic->address_detail;
                $address_detail_en = $request->input('address_detail_en') ?? $clinic->address_detail_en;
                $detail_address_laos = $request->input('address_detail_laos') ?? $clinic->address_detail_laos;
                $nation_id = $request->input('nation_id');
                $province_id = $request->input('province_id');
                $district_id = $request->input('district_id');
                $commune_id = $request->input('commune_id');
                $longitude = $request->input('longitude') ?? $clinic->longitude;
                $latitude = $request->input('latitude') ?? $clinic->latitude;
                $open_date = $request->input('open_date') ?? $clinic->open_date;
                $close_date = $request->input('close_date') ?? $clinic->close_date;
                $introduce = $request->input('introduce') ?? $clinic->introduce;
                $type = $request->input('type') ?? $clinic->type;
                $clinics_service = $request->input('clinics_service');
                $time_work = $request->input('time_work') ?? $clinic->time_work;
                $emergency = $request->has('emergency') ? $request->input('emergency') : 0;
                $insurance = $request->has('insurance') ? $request->input('insurance') : 0;
                $parking = $request->has('parking') ? $request->input('parking') : 0;
                $information = $request->input('hospital_information') ?? $clinic->information;
                $facilities = $request->input('hospital_facilities') ?? $clinic->facilities;
                $equipment = $request->input('hospital_equipment') ?? $clinic->equipment;
                $costs = $request->input('costs') ?? $clinic->costs;
                $representativeDoctor = $request->input('representative_doctor') ?? $clinic->representative_doctor;

                $department = $request->input('departments') ?? $clinic->department;
                $symptoms = $request->input('symptoms') ?? $clinic->symptom;

                if ($request->hasFile('gallery')) {
                    $galleryPaths = array_map(function ($image) {
                        $itemPath = $image->store('gallery', 'public');
                        return asset('storage/' . $itemPath);
                    }, $request->file('gallery'));
                    $gallery = implode(',', $galleryPaths);
                } else {
                    $gallery = $clinic->gallery;
                }

                $clinic->name = $name;
                $clinic->phone = $phone;
                $clinic->email = $email;
                $clinic->name_en = $name_en ?? '';
                $clinic->name_laos = $name_laos ?? '';
                $clinic->longitude = $longitude;
                $clinic->latitude = $latitude;
                $clinic->address_detail = $address_detail;
                $clinic->address_detail_laos = $detail_address_laos ?? '';
                $clinic->address_detail_en = $address_detail_en ?? '';
                $address = [
                    'nation_id' => $nation_id,
                    'province_id' => $province_id,
                    'district_id' => $district_id,
                    'commune_id' => $commune_id
                ];

                $clinic->department = $department;
                $clinic->symptom = $symptoms;

                $clinic->address = implode(',', $address);

                $clinic->open_date = $open_date ?? Carbon::now()->addHours(7);
                $clinic->close_date = $close_date ?? Carbon::now()->addHours(7)->addDay();
                $clinic->introduce = $introduce;
                $clinic->gallery = $gallery;
                $clinic->type = $type;
                $clinic->status = $status ?? ClinicStatus::ACTIVE;
                $clinic->service_id = $clinics_service;
                $clinic->time_work = $time_work;
                $clinic->emergency = $emergency;
                $clinic->insurance = $insurance;
                $clinic->parking = $parking;
                $clinic->information = $information;
                $clinic->facilities = $facilities;
                $clinic->equipment = $equipment;
                $clinic->costs = $costs;
                $clinic->representative_doctor = $representativeDoctor;

                $success = $clinic->save();

                if ($success) {
                    return response()->json($clinic);
                }
                return response((new MainApi())->returnMessage('Update error!'), 400);
            } else {
                return response((new MainApi())->returnMessage($data['message']), $data['status']);
            }
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }

    public function showBusiness(Request $request)
    {
        try {
            $data = (new MainApi())->handleToken();
            if ($data['status'] == 200) {
                $user = $data['data'];

                if (!$user || $user->status == UserStatus::DELETED) {
                    return response((new MainApi())->returnMessage('User not found!'), 404);
                }

                if ($user->type != Role::BUSINESS) {
                    return response((new MainApi())->returnMessage('User not a business activity!'), 400);
                }

                return response()->json(Clinic::where('user_id', $user->id)->first());
            } else {
                return response((new MainApi())->returnMessage($data['message']), $data['status']);
            }
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }
}
