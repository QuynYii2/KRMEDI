<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\DoctorInfoStatus;
use App\Enums\TypeMedical;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TranslateController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDoctorInfoApi extends Controller
{
    public function getAll(Request $request)
    {
        $status = $request->input('status');
        if ($status) {
            $doctor_infos = User::where('status', $status)
                ->where('member', TypeMedical::DOCTORS)
                ->get();
        } else {
            $doctor_infos = User::where('status', '!=', DoctorInfoStatus::DELETED)
                ->where('member', TypeMedical::DOCTORS)
                ->get();
        }
        return response()->json($doctor_infos);
    }

    public function getAllByUser()
    {
        $doctor_infos_byUser = User::where('member', TypeMedical::DOCTORS)
            ->where('status', '!=', UserStatus::DELETED)
            ->get();
        return response()->json($doctor_infos_byUser);
    }

    public function search(Request $request)
    {

    }

    public function findByUser($id)
    {
        $doctor_infos = User::where('created_by', $id)
            ->where('member', TypeMedical::DOCTORS)
            ->first();
        if (!$doctor_infos || $doctor_infos->status == UserStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($doctor_infos);
    }

    public function detail(Request $request, $id)
    {
        $doctor_infos = User::where('id', $id)
            ->where('member', TypeMedical::DOCTORS)
            ->first();
        if (!$doctor_infos || $doctor_infos->status == UserStatus::DELETED) {
            return response('Not found', 404);
        }
        return response()->json($doctor_infos);
    }

    public function create(Request $request)
    {
        try {
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $member = $request->input('member');

            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                toast('Email invalid!', 'error', 'top-left');
                return back();
            }
            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                return response('Email already exited!', 400);
            }

            $oldUserName = User::where('username', $username)->first();
            if ($oldUserName) {
                return response('Username already exited!', 400);
            }

            if ($password != $passwordConfirm) {
                return response('Password or Password Confirm incorrect!', 400);
            }

            if (strlen($password) < 5) {
                return response('Password invalid!', 400);
            }

            $doctor_infos = new User();
            $created_by = Auth::user()->id;
            $item = $this->saveDoctorInfo($request, $doctor_infos, $created_by);
            if ($item) {
                (new MainController())->createRoleUser($member, $username);

                if ($doctor_infos->member == 'DOCTORS') {
                    toast('Register success!', 'success', 'top-left');
                    return redirect()->route('profile');
                }

                toast('Register success!', 'success', 'top-left');
                return redirect(route('home'));
            }

            if ($item) {
                return response()->json($doctor_infos);
            }
            return response("Create error!", 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    private function saveDoctorInfo($request, $doctor, $created_by)
    {
        $translate = new TranslateController();

        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');

        $member = $request->input('member');
        $type = $request->input('type');

        $name = $request->input('name');

        $last_name = $request->input('last_name');
        $phone = $request->input('phone');

        $specialty = $request->input('specialty');

        $specialty_en = $translate->translateText($specialty, 'en');
        $specialty_laos = $translate->translateText($specialty, 'lo');

        $year_of_experience = $request->input('year_of_experience');

        if ($request->hasFile('avt')) {
            $item = $request->file('avt');
            $itemPath = $item->store('doctor', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        } else {
            if ($doctor->avt) {
                $thumbnail = $doctor->avt;
            } else {
                $thumbnail = '';
            }
        }

        $service = $request->input('service');

        $service_en = $translate->translateText($service, 'en');
        $service_laos = $translate->translateText($service, 'lo');

        $about_vn = $request->input('about_vn');

        $about_en = $translate->translateText($about_vn, 'en');
        $about_lao = $translate->translateText($about_vn, 'lo');

        $service_price = $request->input('service_price');

        $service_price_en = $translate->translateText($service_price, 'en');
        $service_price_laos = $translate->translateText($service_price, 'lo');

        $time_working_1 = $request->input('time_working_1');
        $time_working_2 = $request->input('time_working_2');

        $province = $request->input('province_id');
        $district = $request->input('district_id');
        $commune = $request->input('commune_id');
        $update_by = $request->input('update_by');

        $provinceArray = explode('-', $province);
        $districtArray = explode('-', $district);
        $communeArray = explode('-', $commune);

        $province_id = $provinceArray[0];
        $district_id = $districtArray[0];
        $commune_id = $communeArray[0];

        $detail_address = $request->input('detail_address');

        $detail_address_en = $translate->translateText($detail_address, 'en');
        $detail_address_laos = $translate->translateText($detail_address, 'lo');

        $updated_by = $request->input('updated_by');
        $workspace = $request->input('workspace');

        $hospital = $request->input('hospital');
        $hospital_en = $translate->translateText($hospital, 'en');
        $hospital_laos = $translate->translateText($hospital, 'lo');

        $status = $request->input('status');

        $apply_for = $request->input('apply_for');
        if (!$apply_for) {
            $apply_for = 'none';
        }

        $department_id = $request->input('department_id');
        $symptom_id = $request->input('symptom_id');
        $address_code = $request->input('address_code');


        $doctor->name = $name;
        $doctor->username = $username;
        $doctor->last_name = $last_name;
        $doctor->phone = $phone;
        $doctor->workplace = $workspace;
        $doctor->email = $email;
        if ($password) {
            $passwordHash = Hash::make($password);
            $doctor->password = $passwordHash;
        }

        $doctor->avt = $thumbnail;

        $doctor->member = $member;
        $doctor->type = $type;
        $doctor->updated_by = $updated_by;
        $doctor->specialty = $specialty;
        $doctor->specialty_en = $specialty_en;
        $doctor->specialty_laos = $specialty_laos;

        $doctor->year_of_experience = $year_of_experience;

        $doctor->service = $service;
        $doctor->service_en = $service_en;
        $doctor->service_laos = $service_laos;

        $doctor->abouts = $about_vn;
        $doctor->abouts_en = $about_en;
        $doctor->abouts_lao = $about_lao;

        $doctor->service_price = $service_price;
        $doctor->service_price_en = $service_price_en;
        $doctor->service_price_laos = $service_price_laos;

        $doctor->time_working_1 = $time_working_1;
        $doctor->time_working_2 = $time_working_2;

        if ($address_code) {
            $doctor->address_code = $address_code;
        }
        $doctor->province_id = $province_id;
        $doctor->district_id = $district_id;
        $doctor->commune_id = $commune_id;


        $doctor->detail_address = $detail_address;
        $doctor->detail_address_en = $detail_address_en;
        $doctor->detail_address_laos = $detail_address_laos;
        if ($update_by) {
            $doctor->updated_by = $update_by;
        }
        if ($created_by !== "undefined") {
            $doctor->created_by = $created_by;
        }

        $doctor->status = $status;
        $doctor->apply_for = $apply_for;

        $doctor->department_id = $department_id;
        $doctor->symptom_id = $symptom_id;
        $doctor->identifier = $request->input('identifier') ?? null;
        return $doctor->save();
    }

    public function update(Request $request, $id)
    {
        try {
            $doctor_infos = User::where('id', $id)->first();
            if (!$doctor_infos || $doctor_infos->status == UserStatus::DELETED) {
                return response('Not found', 404);
            }

            $created_by = "undefined";
            $item = $this->saveDoctorInfo($request, $doctor_infos, $created_by);
            if ($item) {
                return response()->json($doctor_infos);
            }
            return response("Update error!", 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        try {
            $doctor_infos = User::where('id', $id)->first();
            if (!$doctor_infos || $doctor_infos->status == UserStatus::DELETED) {
                return response('Not found', 404);
            }
            $doctor_infos->status = UserStatus::DELETED;
            $success = $doctor_infos->save();
            if ($success) {
                return response('Delete success!', 200);
            }
            return response('Delete error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
