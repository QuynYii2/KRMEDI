<?php

namespace App\Http\Controllers\backend;

use App\Enums\ClinicStatus;
use App\Enums\TypeBusiness;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\TranslateController;
use App\Models\Clinic;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BackendClinicController extends Controller
{
    public function getAll()
    {
        $clinics = Clinic::where('type', TypeBusiness::CLINICS)
            ->where('status', '!=', ClinicStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($clinics);
    }

    public function getAllPharmacies()
    {
        $clinics = Clinic::where('type', TypeBusiness::PHARMACIES)
            ->where('status', '!=', ClinicStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($clinics);
    }

    public function getAllHospitals()
    {
        $clinics = Clinic::where('type', TypeBusiness::HOSPITALS)
            ->where('status', '!=', ClinicStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($clinics);
    }

    public function getAllClinicActive()
    {
        if ($this->isAdmin()) {
            $clinics = Clinic::where('status', ClinicStatus::ACTIVE)->get();
        } else {
            if (Auth::user()->manager_id) {
                $clinics = Clinic::where('status', ClinicStatus::ACTIVE)->where('user_id',
                    Auth::user()->manager_id)->get();
            } else {
                $clinics = Clinic::where('status', ClinicStatus::ACTIVE)->where('user_id', Auth::user()->id)->get();
            }
        }
        return response()->json($clinics);
    }

    public function isAdmin()
    {
        $role_user = RoleUser::where('user_id', Auth::user()->id)->first();

        $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

        if ($roleNames->contains('ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllByUserId(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status && $status != ClinicStatus::DELETED) {
            $clinics = Clinic::where([
                ['status', $status],
                ['user_id', $id]
            ])->where('type', TypeBusiness::CLINICS)->get();
        } else {
            $clinics = Clinic::where([
                ['status', '!=', ClinicStatus::DELETED],
                ['user_id', $id]
            ])->where('type', TypeBusiness::CLINICS)->get();
        }
        return response()->json($clinics);
    }

    public function create(Request $request)
    {
        try {
            $clinic = new Clinic();

            $name = $request->input('name');
            if ($name == null) {
                return redirect()->back()->withInput()->withErrors('name', 'Tên không được để trống');
            }

            $translate = new TranslateController();
            $name_en = $translate->translateText($name, 'en');
            $name_laos = $translate->translateText($name, 'lo');

            $phone = $request->input('phone');
            if ($phone == null) {
                return redirect()->back()->withInput()->withErrors('name', 'Số điện thoại không được để trống');
            }
            $email = $request->input('email');
            $address_detail = $request->input('address_detail');

            $address_detail_en = $translate->translateText($address_detail, 'en');
            $address_detail_laos = $translate->translateText($address_detail, 'lo');


            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $longitude = $request->input('longitude');
            $latitude = $request->input('latitude');
            $commune_id = $request->input('commune_id');
            $introduce = $request->input('introduce');

            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            }else{
                $gallery = "";
            }

            $time_work = $request->input('time_work');
            $clinics_service = $request->input('clinics_service');
            $open_date = $request->input('open_date');
            $close_date = $request->input('close_date');
            $type = $request->input('type');

            $emergency = $request->has('emergency') ? $request->input('emergency') : 0;
            $insurance = $request->has('insurance') ? $request->input('insurance') : 0;
            $parking = $request->has('parking') ? $request->input('parking') : 0;
            $information = $request->input('hospital_information');
            $facilities = $request->input('hospital_facilities');
            $equipment = $request->input('hospital_equipment');
            $costs = $request->input('costs');
            $representativeDoctor = $request->input('representative_doctor');

            $department = $request->input('departments');
            $symptoms = $request->input('symptoms');

            $status = $request->input('status');

            $user_id = $request->input('user_id');
            /* Save user */
            $user = new User();

            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');

            $oldUser = User::where('phone', $phone)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Phone already exited!'), 400);
            }

            if ($password != $passwordConfirm) {
                return response((new MainApi())->returnMessage('Password or Password Confirm incorrect!!'), 400);
            }

            if (strlen($password) < 5) {
                return response((new MainApi())->returnMessage('Password invalid!'), 400);
            }

            $user->email = $email;
            $user->phone = $phone;
            $user->province_id = $province_id;
            $user->district_id = $district_id;
            $user->commune_id = $commune_id;
            $user->detail_address = $address_detail;
            $user->year_of_experience = 0;
            $user->bac_si_dai_dien = $representativeDoctor;
            $user->name = $name;
            $user->last_name = $name;
            $user->password = Hash::make($password);
            $user->address_code = '';
            $user->type = \App\Enums\Role::BUSINESS;
            $user->member = $type;
            $user->abouts = 'default';
            $user->abouts_en = 'default';
            $user->abouts_lao = 'default';
            $user->status = UserStatus::ACTIVE;
            $user->save();

            $clinic->name = $name;
            $clinic->phone = $phone;
            $clinic->email = $email;
            $clinic->name_en = $name_en ?? '';
            $clinic->name_laos = $name_laos ?? '';
            $clinic->longitude = $longitude;
            $clinic->latitude = $latitude;
            $clinic->address_detail = $address_detail;
            $clinic->address_detail_en = $address_detail_en ?? '';
            $clinic->address_detail_laos = $address_detail_laos ?? '';

            $clinic->time_work = $time_work;
            $clinic->type = $type;
            $clinic->service_id = $clinics_service;
            $clinic->representative_doctor = $representativeDoctor;

            $clinic->department = $department;
            $clinic->symptom = $symptoms;

            $address = [
                'nation_id' => $nation_id,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'commune_id' => $commune_id
            ];

            $clinic->created_by = $user_id ?? null;

            $clinic->address = implode(',', $address);

            $clinic->open_date = $open_date ?? Carbon::now()->addHours(7);
            $clinic->close_date = $close_date ?? Carbon::now()->addHours(7)->addDay();
            $clinic->introduce = $introduce;
            $clinic->gallery = $gallery;
            $clinic->status = $status ?? ClinicStatus::ACTIVE;
            $clinic->emergency = $emergency;
            $clinic->insurance = $insurance;
            $clinic->parking = $parking;
            $clinic->information = $information;
            $clinic->facilities = $facilities;
            $clinic->equipment = $equipment;
            $clinic->costs = $costs;

            (new MainController())->createRoleUsers($type, $phone);

            $clinic->user_id = $user->id;

            $success = $clinic->save();
            if ($success) {
                toast('Success, Create profile success!', 'success', 'top-left');
                return redirect()->route('homeAdmin.list.clinics');
            }
            return redirect()->back()->withInput();
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function detail($id)
    {
        $clinic = Clinic::find($id);
        return response()->json($clinic);
    }

    public function updateNew($id, Request $request)
    {
        try {
            $clinic = Clinic::find($id);

            $name = $request->input('name');

            $translate = new TranslateController();
            $name_en = $translate->translateText($name, 'en');
            $name_laos = $translate->translateText($name, 'lo');

            $phone = $request->input('phone') ?? $clinic->phone;
            $email = $request->input('email');
            $address_detail = $request->input('address_detail') ?? $clinic->address_detail;

            $address_detail_en = $translate->translateText($address_detail, 'en');
            $address_detail_laos = $translate->translateText($address_detail, 'lo');

            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $longitude = $request->input('longitude') ?? $clinic->longitude;
            $latitude = $request->input('latitude') ?? $clinic->latitude;
            $open_date = $request->input('open_date') ?? $clinic->open_date;
            $close_date = $request->input('close_date') ?? $clinic->close_date;
            $introduce = $request->input('introduce') ?? $clinic->introduce;
            $status = $request->input('status') ?? $clinic->status;
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
            $clinic->address_detail_laos = $address_detail_laos ?? '';
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

            $user = User::where('id', $clinic->user_id)->first();
            $user->name = $name;
            $user->phone = $phone;
            $user->email = $email;
            $user->province_id = $province_id;
            $user->district_id = $district_id;
            $user->commune_id = $commune_id;
            $user->detail_address = $address_detail;
            $user->bac_si_dai_dien = $representativeDoctor;

            $successful = $user->save();
            $success = $clinic->save();
            if ($success && $successful) {
                toast('Success, Update profile success!', 'success', 'top-left');
                return redirect()->route('homeAdmin.list.clinics');
            }
            return redirect()->back()->withInput();
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $clinic = Clinic::find($id);
            if (!$clinic || $clinic->status == ClinicStatus::DELETED) {
                return response("Clinic not found", 404);
            }
            $clinic->status = ClinicStatus::DELETED;
            $success = $clinic->save();
            if ($success) {
                return response("Delete success!", 200);
            }
            return response("Error, Please try again!", 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function getOutstandingHospitalClinic()
    {
        $clinics = DB::table('clinics')
            ->leftJoin('bookings', 'clinics.id', '=', 'bookings.clinic_id')
            ->select(
                'clinics.id',
                'clinics.name',
                'clinics.name_en',
                'clinics.address_detail',
                'clinics.latitude',
                'clinics.longitude',
                'clinics.experience',
                'clinics.address_detail_en',
                'clinics.address',
                'clinics.user_id',
                'clinics.introduce',
                'clinics.gallery',
                'clinics.status',
                'clinics.created_at',
                'clinics.updated_at',
                'clinics.name_laos',
                'clinics.type',
                'clinics.phone',
                'clinics.email',
                'clinics.count',
                'clinics.time_work',
                'clinics.address_detail_laos',
                'clinics.open_date',
                'clinics.close_date',
                'clinics.service_id',
                'clinics.department',
                'clinics.symptom',
                'clinics.emergency',
                'clinics.insurance',
                'clinics.parking',
                'clinics.information',
                'clinics.facilities',
                'clinics.equipment',
                'clinics.costs',
                'clinics.average_star',
                'clinics.representative_doctor',
                'clinics.created_by',
                DB::raw('COUNT(bookings.id) as booking_count')
            )
            ->where('clinics.type', 'CLINICS')
            ->groupBy(
                'clinics.id',
                'clinics.name',
                'clinics.name_en',
                'clinics.address_detail',
                'clinics.latitude',
                'clinics.longitude',
                'clinics.experience',
                'clinics.address_detail_en',
                'clinics.address',
                'clinics.user_id',
                'clinics.introduce',
                'clinics.gallery',
                'clinics.status',
                'clinics.created_at',
                'clinics.updated_at',
                'clinics.name_laos',
                'clinics.type',
                'clinics.phone',
                'clinics.email',
                'clinics.count',
                'clinics.time_work',
                'clinics.address_detail_laos',
                'clinics.open_date',
                'clinics.close_date',
                'clinics.service_id',
                'clinics.department',
                'clinics.symptom',
                'clinics.emergency',
                'clinics.insurance',
                'clinics.parking',
                'clinics.information',
                'clinics.facilities',
                'clinics.equipment',
                'clinics.costs',
                'clinics.average_star',
                'clinics.representative_doctor',
                'clinics.created_by'
            )
            ->orderByDesc('booking_count')
            ->get();

        $hospitals = DB::table('clinics')
            ->leftJoin('bookings', 'clinics.id', '=', 'bookings.clinic_id')
            ->select(
                'clinics.id',
                'clinics.name',
                'clinics.name_en',
                'clinics.address_detail',
                'clinics.latitude',
                'clinics.longitude',
                'clinics.experience',
                'clinics.address_detail_en',
                'clinics.address',
                'clinics.user_id',
                'clinics.introduce',
                'clinics.gallery',
                'clinics.status',
                'clinics.created_at',
                'clinics.updated_at',
                'clinics.name_laos',
                'clinics.type',
                'clinics.phone',
                'clinics.email',
                'clinics.count',
                'clinics.time_work',
                'clinics.address_detail_laos',
                'clinics.open_date',
                'clinics.close_date',
                'clinics.service_id',
                'clinics.department',
                'clinics.symptom',
                'clinics.emergency',
                'clinics.insurance',
                'clinics.parking',
                'clinics.information',
                'clinics.facilities',
                'clinics.equipment',
                'clinics.costs',
                'clinics.average_star',
                'clinics.representative_doctor',
                'clinics.created_by',
                DB::raw('COUNT(bookings.id) as booking_count')
            )
            ->where('clinics.type', 'HOSPITALS')
            ->groupBy(
                'clinics.id',
                'clinics.name',
                'clinics.name_en',
                'clinics.address_detail',
                'clinics.latitude',
                'clinics.longitude',
                'clinics.experience',
                'clinics.address_detail_en',
                'clinics.address',
                'clinics.user_id',
                'clinics.introduce',
                'clinics.gallery',
                'clinics.status',
                'clinics.created_at',
                'clinics.updated_at',
                'clinics.name_laos',
                'clinics.type',
                'clinics.phone',
                'clinics.email',
                'clinics.count',
                'clinics.time_work',
                'clinics.address_detail_laos',
                'clinics.open_date',
                'clinics.close_date',
                'clinics.service_id',
                'clinics.department',
                'clinics.symptom',
                'clinics.emergency',
                'clinics.insurance',
                'clinics.parking',
                'clinics.information',
                'clinics.facilities',
                'clinics.equipment',
                'clinics.costs',
                'clinics.average_star',
                'clinics.representative_doctor',
                'clinics.created_by'
            )
            ->orderByDesc('booking_count')
            ->get();

        $clinics->transform(function ($clinic) {
            $gallery = explode(',', $clinic->gallery);
            $clinic->gallery = $gallery[0] ?? null;
            return $clinic;
        });

        $hospitals->transform(function ($hospital) {
            $gallery = explode(',', $hospital->gallery);
            $hospital->gallery = $gallery[0] ?? null;
            return $hospital;
        });

        $mergedList = [];
        $maxLength = max($clinics->count(), $hospitals->count());

        for ($i = 0; $i < $maxLength; $i++) {
            if (isset($clinics[$i])) {
                $mergedList[] = $clinics[$i];
            }
            if (isset($hospitals[$i])) {
                $mergedList[] = $hospitals[$i];
            }
        }
        return response()->json($mergedList);
    }

    public function getOutstandingDoctor()
    {
        $doctors = DB::table('users')
            ->leftJoin('bookings', 'users.id', '=', 'bookings.doctor_id')
            ->select([
                'users.*',
                DB::raw('COUNT(bookings.id) as read_count')
            ])
            ->where('users.status', 'ACTIVE')
            ->groupBy(
                'users.id',
                'users.name',
                'users.last_name',
                'users.email',
                'users.identifier',
                'users.email_verified_at',
                'users.password',
                'users.remember_token',
                'users.created_at',
                'users.updated_at',
                'users.username',
                'users.phone',
                'users.address_code',
                'users.type',
                'users.member',
                'users.status',
                'users.avt',
                'users.provider_name',
                'users.detail_address',
                'users.detail_address_en',
                'users.detail_address_laos',
                'users.provider_id',
                'users.manager_id',
                'users.nation_id',
                'users.province_id',
                'users.district_id',
                'users.commune_id',
                'users.hospital',
                'users.hospital_en',
                'users.hospital_laos',
                'users.business_license_img',
                'users.medical_license_img',
                'users.gender',
                'users.birthday',
                'users.specialty',
                'users.specialty_en',
                'users.specialty_laos',
                'users.year_of_experience',
                'users.service',
                'users.service_en',
                'users.service_laos',
                'users.service_price',
                'users.service_price_en',
                'users.service_price_laos',
                'users.time_working_1',
                'users.time_working_2',
                'users.created_by',
                'users.updated_by',
                'users.department_id',
                'users.apply_for',
                'users.rate',
                'users.bac_si_dai_dien',
                'users.latitude',
                'users.longitude',
                'users.symptom_id',
                'users.average_star',
                'users.prescription',
                'users.free',
                'users.abouts',
                'users.abouts_en',
                'users.abouts_lao',
                'users.workplace',
                'users.last_seen',
                'users.token',
                'users.medical_history',
                'users.is_check_medical_history',
                'users.is_verify',
                'users.verify_code',
                'users.points',
                'users.token_firebase',
                'users.extend',
                'users.identify_number',
                'users.signature',
                'users.last_session',
                'users.insurance_id',
                'users.health_insurance_back',
                'users.health_insurance_front',
                'users.date_health_insurance',
                'users.devices_name',
                'users.devices_id',
                'users.client_id_kiot_viet',
                'users.client_secret_kiot_viet',
                'users.retailer_kiot_viet',
                'users.is_send'
            )
            ->orderByDesc('read_count')
            ->get();

        return response()->json($doctors);
    }

}
