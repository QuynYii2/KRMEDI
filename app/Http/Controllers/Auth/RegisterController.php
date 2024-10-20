<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ClinicStatus;
use App\Enums\TypeTimeWork;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Clinic;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Rules\NoSpacesRule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'string', 'unique:users,username', new NoSpacesRule],
                'password' => ['required', 'string', new NoSpacesRule],
                'passwordConfirm' => ['required', 'string', 'same:password', new NoSpacesRule],
                'member' => ['required', 'string'],
                'medical_history' => ['nullable'],
                'type' => ['required', 'string'],
                'open_date' => ['nullable'],
                'close_date' => ['nullable'],
                'province_id' => ['nullable'],
                'district_id' => ['nullable'],
                'commune_id' => ['nullable'],
                'address' => ['nullable', 'string'],
                'time_work' => ['nullable'],
                'provider_name' => ['nullable'],
                'provider_id' => ['nullable'],
                'invite_code' => ['nullable'],
                'combined_address' => ['nullable'],
                'representative' => ['nullable'],
                'latitude' => ['nullable'],
                'longitude' => ['nullable'],
                'experienceHospital' => ['nullable'],
                'fileupload' => ['nullable', 'file'],
                'name_doctor' => ['nullable', 'required_if:type,MEDICAL'],
                'contact_phone' => ['nullable', 'required_if:type,MEDICAL', 'unique:users,phone', 'regex:/^0[1-9][0-9]{8}$/'],
                'experience' => ['nullable', 'integer'],
                'hospital' => ['nullable', 'string'],
                'specialized_services' => ['nullable', 'string'],
                'services_info' => ['nullable', 'string'],
                'identifier' => ['nullable'],
                'prescription' => ['nullable'],
                'free' => ['nullable'],
                'signature' => ['nullable', 'required_if:member,DOCTORS']
            ]);

            if ($validator->fails()) {
                return response((new MainApi())->returnMessage($validator->errors()->first()), 400);
            }

            /* All user */
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $member = $request->input('member');
            $medical_history = $request->input('medical_history');
            $type = $request->input('type');
            $provider_name = $request->input('provider_name') ?? "";
            $provider_id = $request->input('provider_id') ?? "";

            $invite_code = $request->input('inviteCode') ?? "";

            $signature = $request->file('signature') ?? "";

            if ($signature) {
                $itemPath = $signature->store('signature', 'public');
                $imageUrl = asset('storage/' . $itemPath);
            }

            $identify_number = Str::random(8);
            while (User::where('identify_number', $identify_number)->exists()) {
                $identify_number = Str::random(8);
            }

            /* Only type medical */
            $name = $request->input('name_doctor');
            $contact_phone = $request->input('contact_phone');
            $experience = $request->input('experience');
            $name_hospital = $request->input('name_hospital');
            $specialized_services = $request->input('specialized_services');
            $services_info = $request->input('services_info');
            $prescription = $request->input('prescription');
            $free = $request->input('free_question');
            $abouts = $request->input('abouts_doctor');

            /* Only type business */
            $open_date = $request->input('open_date');
            $close_date = $request->input('close_date');
            $experienceHospital = $request->input('experienceHospital');
            $address = $request->input('address');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $representative = $request->input('representative');
            $time_work = $request->input('time_work') ?? TypeTimeWork::ALL;

            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                return response((new MainApi())->returnMessage('Email invalid!'), 400);
            }

            $user = new User();

            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Email already exited!'), 400);
            }

            $oldUser = User::where('username', $username)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Username already exited!'), 400);
            }

            if ($password != $passwordConfirm) {
                return response((new MainApi())->returnMessage('Password or Password Confirm incorrect!'), 400);
            }

            if (strlen($password) < 5) {
                return response((new MainApi())->returnMessage('Password invalid!'), 400);
            }

            $checkPending = false;
            if ($type == \App\Enums\Role::BUSINESS) {
                // kiểm tra xem fileupload có tồn tại không, nếu không thì thông báo lỗi
                if (!$request->hasFile('fileupload')) {
                    return response((new MainApi())->returnMessage('Cần up file giấy phép kinh doanh'), 400);
                }
                $item = $request->file('fileupload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->business_license_img = $img;
                $checkPending = true;
                $user->prescription = $prescription ? (int)$prescription : 0;
                $user->free = $free ? (int)$free : 0;
            }

            if ($type == \App\Enums\Role::MEDICAL) {
                // kiểm tra xem fileupload có tồn tại không, nếu không thì thông báo lỗi
                if (!$request->hasFile('fileupload')) {
                    return response((new MainApi())->returnMessage('Cần up file giấy phép nghề nghiệp'), 400);
                }
                $item = $request->file('fileupload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->medical_license_img = $img;

                if ($imageUrl) {
                    $user->signature = $imageUrl;
                }

                $checkPending = true;
                /* Set data for user type with medical */
                $user->year_of_experience = $experience ?? '';
                $user->hospital = $name_hospital ?? '';
                $user->specialty = $specialized_services ?? '';
                $user->service = $services_info ?? '';
                $user->prescription = $prescription ? (int)$prescription : 0;
                $user->free = $free ? (int)$free : 0;
                $user->abouts = $abouts ?? '';
            }

            if ($member == \App\Enums\Role::NORMAL_PEOPLE || $member == \App\Enums\Role::PAITENTS) {
                $user->medical_history = $medical_history;
            }

            $user->email = $email;
            $user->name = $name ?? $username;
            $user->last_name = $name ?? '';
            $user->provider_name = $provider_name;
            $user->provider_id = $provider_id;
            $user->identify_number = $identify_number;
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->phone = $contact_phone ?? '';
            $user->address_code = '';
            $user->type = $type;
            $user->member = $member;
            $user->abouts = 'default';
            $user->abouts_en = 'default';
            $user->abouts_lao = 'default';

            if ($checkPending) {
                $user->status = UserStatus::PENDING;
            } else {
                $user->status = UserStatus::ACTIVE;
            }

            $success = $user->save();

            if ($user->type == \App\Enums\Role::BUSINESS) {
                $clinic = new Clinic();
                $currentDate = Carbon::now();
                $openDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $open_date);
                $closeDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $close_date);
                $formattedOpenDateTime = $openDateTime->format('Y-m-d\TH:i');
                $formattedCloseDateTime = $closeDateTime->format('Y-m-d\TH:i');

                $clinic->address_detail = $address;
                $province = Province::find($province_id);
                $district = District::find($district_id);
                $commune = Commune::find($commune_id);
                $clinic->address = $address . ',' . $province->name . ',' . $district->name . ',' . $commune->name;

                $clinic->name = $representative;
                $clinic->open_date = $formattedOpenDateTime ?? '';
                $clinic->close_date = $formattedCloseDateTime ?? '';
                $clinic->experience = $experienceHospital;
                $clinic->gallery = '';
                $clinic->user_id = $user->id;
                $clinic->time_work = $time_work;
                $clinic->status = ClinicStatus::ACTIVE;
                $clinic->type = $member;
                $clinic->representative_doctor = $representative;

                $clinic->save();

                $user->province_id = $province_id;
                $user->district_id = $district_id;
                $user->commune_id = $commune_id;
                $user->address_code = $province->name;
                $user->detail_address = $address;
                $user->year_of_experience = $experienceHospital;
                $user->bac_si_dai_dien = $representative;
                $user->name = $representative;
                $user->save();
            }

            if ($success) {
                //Cộng điểm giới thiệu
                if ($invite_code) {
                    $getUserInvite = User::where('identify_number', $identify_number)->first();
                    $getUserInvite->points = $getUserInvite->points + 1;
                    $getUserInvite->save();
                }
                (new MainController())->createRoleUser($member, $username);
                $response = $user->toArray();
                $roleUser = RoleUser::where('user_id', $user->id)->first();
                $role = Role::find($roleUser->role_id);
                $response['role'] = $role->name;
                return response()->json($response);
            }
            return response((new MainApi())->returnMessage('Register fail!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function registerPhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => ['required', 'string', 'unique:users,phone'],
                'password' => ['required', 'string', new NoSpacesRule],
                'passwordConfirm' => ['required', 'string', 'same:password', new NoSpacesRule],
                'invite_code' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return response((new MainApi())->returnMessage($validator->errors()->first()), 400);
            }
            /* All user */
            $phone = $request->input('phone');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $invite_code = $request->input('inviteCode') ?? "";
            $medical_history = $request->input('medical_history');

            $identify_number = Str::random(8);
            while (User::where('identify_number', $identify_number)->exists()) {
                $identify_number = Str::random(8);
            }

            $user = new User();
            $oldUser = User::where('phone', $phone)->first();
            if ($oldUser) {
                return response((new MainApi())->returnMessage('Phone already exited!'), 400);
            }
            if ($password != $passwordConfirm) {
                return response((new MainApi())->returnMessage('Password or Password Confirm incorrect!'), 400);
            }
            if (strlen($password) < 5) {
                return response((new MainApi())->returnMessage('Password invalid!'), 400);
            }
            $user->phone = $phone;
            $user->password = Hash::make($password);
            $user->type = 'NORMAL';
            $user->member = 'PAITENTS';
            $user->abouts = 'default';
            $user->abouts_en = 'default';
            $user->abouts_lao = 'default';
            $user->status = UserStatus::ACTIVE;
            $user->email = $phone."@gmail.com";
            $user->medical_history = $medical_history;

            $success = $user->save();

            if ($success) {
                //Cộng điểm giới thiệu
                if ($invite_code) {
                    $getUserInvite = User::where('identify_number', $identify_number)->first();
                    $getUserInvite->points = $getUserInvite->points + 1;
                    $getUserInvite->save();
                }
                $newUser = User::where('phone', $phone)->first();

                $roleNormal = Role::where('name', \App\Enums\Role::PAITENTS)->first();
                RoleUser::create([
                    'role_id' => $roleNormal->id,
                    'user_id' => $newUser->id
                ]);
                $response = $user->toArray();
                $roleUser = RoleUser::where('user_id', $user->id)->first();
                $role = Role::find($roleUser->role_id);
                $response['role'] = $role->name;
                return response()->json($response);
            }
            return response((new MainApi())->returnMessage('Register fail!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }
}
