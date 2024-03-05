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
                return response("Name not null!", 400);
            }

            $translate = new TranslateController();
            $name_en = $translate->translateText($name, 'en');
            $name_laos = $translate->translateText($name, 'lo');

            $phone = $request->input('phone');
            if ($phone == null) {
                return response("Phone not null!", 400);
            }
            $email = $request->input('email');
            if ($email == null) {
                return response("Email not null!", 400);
            }
            $address_detail = $request->input('address_detail');

            $address_detail_en = $translate->translateText($address_detail, 'en');
            $address_detail_laos = $translate->translateText($address_detail, 'lo');

            if ($address_detail == null) {
                return response("Address not null!", 400);
            }
            if ($address_detail_en == null) {
                return response("Address English not null!", 400);
            }
            if ($address_detail_laos == null) {
                return response("Address Laos not null!", 400);
            }

            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            if ($province_id == null) {
                return response("Province not null!", 400);
            }
            $district_id = $request->input('district_id');
            if ($district_id == null) {
                return response("District not null!", 400);
            }
            $longitude = $request->input('longitude');
            $latitude = $request->input('latitude');
            $commune_id = $request->input('commune_id');
            if ($commune_id == null) {
                return response("Commune not null!", 400);
            }
            $introduce = $request->input('introduce');
            if ($introduce == null) {
                return response("Introduce not null!", 400);
            }
            if ($request->hasFile('gallery')) {
                $galleryPaths = array_map(function ($image) {
                    $itemPath = $image->store('gallery', 'public');
                    return asset('storage/' . $itemPath);
                }, $request->file('gallery'));
                $gallery = implode(',', $galleryPaths);
            } else {
                return response("Gallery not null!", 400);
            }

            $time_work = $request->input('time_work');
            if ($time_work == null) {
                return response("Time work not null!", 400);
            }

            $clinics_service = $request->input('clinics_service');
            if ($clinics_service == null) {
                return response("Clinics service not null!", 400);
            }

            $open_date = $request->input('open_date');
            if ($open_date == null) {
                return response("Open date not null!", 400);
            }
            $close_date = $request->input('close_date');
            if ($close_date == null) {
                return response("Close date not null!", 400);
            }

            $type = $request->input('type');

            $emergency = $request->has('emergency') ? $request->input('emergency') : 0;
            $insurance = $request->has('insurance') ? $request->input('insurance') : 0;
            $parking = $request->has('parking') ? $request->input('parking') : 0;
            $information = $request->input('hospital_information');
            if ($information == null) {
                return response("Hospital information not null!", 400);
            }
            $facilities = $request->input('hospital_facilities');
            if ($facilities == null) {
                return response("Hospital facilities not null!", 400);
            }
            $equipment = $request->input('hospital_equipment');
            if ($equipment == null) {
                return response("Hospital equipment not null!", 400);
            }
            $costs = $request->input('costs');
            if ($costs == null) {
                return response("Costs not null!", 400);
            }
            $representativeDoctor = $request->input('representative_doctor');
            if ($representativeDoctor == null) {
                return response("Representative doctor not null!", 400);
            }

            $department = $request->input('departments');
            $symptoms = $request->input('symptoms');

            $status = $request->input('status');

            $user_id = $request->input('user_id');
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

            /* Save user */
            $user = new User();

            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');

            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                return response((new MainApi())->returnMessage('Email invalid!'), 400);
            }

            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Email already exited!'), 400);
            }

            $oldUser = User::where('username', $username)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Username already exited!'), 400);
            }

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

            $user->province_id = explode('-', $province_id)[0];
            $user->district_id = explode('-', $district_id)[0];
            $user->commune_id = explode('-', $commune_id)[0];
            $user->detail_address = $address_detail;
            $user->year_of_experience = 0;
            $user->bac_si_dai_dien = $representativeDoctor;
            $user->name = $name;
            $user->last_name = $name;
            $user->password = Hash::make($password);
            $user->username = $username;
            $user->address_code = '';
            $user->type = \App\Enums\Role::BUSINESS;
            $user->member = $type;
            $user->abouts = 'default';
            $user->abouts_en = 'default';
            $user->abouts_lao = 'default';
            $user->status = UserStatus::ACTIVE;
            $user->save();

            (new MainController())->createRoleUser($type, $username);

            $clinic->user_id = $user->id;

            $success = $clinic->save();
            if ($success) {
                return response()->json($clinic);
            }
            return response("Error, Please try again!", 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function detail($id)
    {
        $clinic = Clinic::find($id);
        return response()->json($clinic);
    }

    public function update($id, Request $request)
    {
        try {
            $clinic = Clinic::find($id);

            $name = $request->input('name') ?? $clinic->name;

            $translate = new TranslateController();
            $name_en = $translate->translateText($name, 'en');
            $name_laos = $translate->translateText($name, 'lo');

            $phone = $request->input('phone') ?? $clinic->phone;
            $email = $request->input('email') ?? $clinic->email;
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


            $success = $clinic->save();
            if ($success) {
                return response()->json($clinic);
            }
            return response("Error, Please try again!", 400);
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
}
