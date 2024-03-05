<?php

namespace App\Http\Controllers\restapi\admin;

use App\Enums\Role;
use App\Enums\TypeTimeWork;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserApi extends Controller
{
    public function getAllUser()
    {
        $admin_role = \App\Models\Role::where('name', Role::ADMIN)->first();
        $users_admin = DB::table('role_users')->where('role_id', $admin_role->id)->get();
        $array_user = [];
        foreach ($users_admin as $item) {
            $array_user[] = $item->user_id;
        }
        $users = User::where('status', '!=', UserStatus::DELETED)
            ->whereNotIn('id', $array_user)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($users);
    }

    public function detail($id)
    {
        $user = User::find($id);
        if (!$user || $user->status == UserStatus::DELETED) {
            return response('User not found!', 404);
        }
        return response()->json($user);
    }

    public function search(Request $request)
    {

    }

    public function create(Request $request)
    {
        try {
            $user = new User();
            $array = $this->saveUser($request, $user);
            if ($array['status'] == 200) {
                $success = $user->save();
                if ($success) {
                    return response()->json($user);
                }
                return response($this->returnMessage('Error, Create error!'), 400);
            } else {
                return response($this->returnMessage($array['data']), $array['status']);
            }
        } catch (\Exception $exception) {
            return response($this->returnMessage('Error, Please try again!'), 400);
        }
    }

    private function saveUser($request, $user)
    {
        $isUpdate = false;
        if ($user->email) {
            $isUpdate = true;
        }
        /* All user */
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');
        $passwordConfirm = $request->input('passwordConfirm');
        $member = $request->input('member');
        $medical_history = $request->input('medical_history');
        $type = $request->input('type');
        $status = $request->input('status');

        $name_user = $request->input('name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');

        $detail_address = $request->input('detail_address');
        $detail_address_en = $request->input('detail_address_en');
        $detail_address_laos = $request->input('detail_address_laos');

        $address_code = $request->input('address_code');

        if ($request->hasFile('avt')) {
            $item = $request->file('avt');
            $itemPath = $item->store('users', 'public');
            $thumbnail = asset('storage/' . $itemPath);
        }

        /* Only type medical */
        $experience = $request->input('year_of_experience');
        if ($experience > 80) {
            $experience = 80;
        }
        $workspace = $request->input('workspace');
        $name_hospital = $request->input('name_hospital');

        $specialized_services = $request->input('specialty');
        $specialized_services_en = $request->input('specialty_en');
        $specialized_services_laos = $request->input('specialty_laos');

        $services_info = $request->input('service');
        $services_info_en = $request->input('service_en');
        $services_info_laos = $request->input('service_laos');

        $service_price = $request->input('service_price');
        $service_price_en = $request->input('service_price_en');
        $service_price_laos = $request->input('service_price_laos');

        $prescription = $request->input('prescription');
        $free = $request->input('free');
        $department_id = $request->input('department_id');

        $abouts = $request->input('abouts_doctor');

        $time_working_1 = $request->input('time_working_1');
        $time_working_2 = $request->input('time_working_2');
        $apply_for = $request->input('apply_for');

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
            return $this->returnArray(400, 'Email invalid!');
        }

        if ($email != $user->email) {
            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                return $this->returnArray(400, 'Email already exited!');
            }
        }

        if ($phone != $user->phone) {
            $oldUser = User::where('phone', $phone)->first();
            if ($oldUser) {
                return $this->returnArray(400, 'Phone already exited!');
            }
        }

        if ($username != $user->username) {
            $oldUser = User::where('username', $username)->first();
            if ($oldUser) {
                return $this->returnArray(400, 'Username already exited!');
            }
        }

        if (!$isUpdate) {
            if ($password != $passwordConfirm) {
                return $this->returnArray(400, 'Password or Password Confirm incorrect!');
            }

            if (strlen($password) < 5) {
                return $this->returnArray(400, 'Password invalid!');
            }
        } else {
            if ($password || $passwordConfirm) {
                if ($password != $passwordConfirm) {
                    return $this->returnArray(400, 'Password or Password Confirm incorrect!');
                }

                if (strlen($password) < 5) {
                    return $this->returnArray(400, 'Password invalid!');
                }
                $user->password = Hash::make($password);
            }
        }

        if ($type == Role::BUSINESS) {
            // kiểm tra xem file_upload có tồn tại không, nếu không thì thông báo lỗi
            if (!$isUpdate) {
                if (!$request->hasFile('file_upload')) {
                    return $this->returnArray(400, 'Cần up file giấy phép kinh doanh');
                }
                $item = $request->file('file_upload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->business_license_img = $img;
            }
            $user->prescription = $prescription ? (int)$prescription : 0;
            $user->free = $free ? (int)$free : 0;
        }

        if ($type == Role::MEDICAL) {
            // kiểm tra xem file_upload có tồn tại không, nếu không thì thông báo lỗi
            if (!$isUpdate) {
                if (!$request->hasFile('file_upload')) {
                    return $this->returnArray(400, 'Cần up file giấy phép nghề nghiệp');
                }
                $item = $request->file('file_upload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->medical_license_img = $img;
            }
            /* Set data for user type with medical */
            $user->year_of_experience = $experience ?? '';
            $user->hospital = $name_hospital ?? '';

            $user->specialty = $specialized_services ?? '';
            $user->specialty_en = $specialized_services_en ?? '';
            $user->specialty_laos = $specialized_services_laos ?? '';
            $user->identifier = $request->input('identifier') ?? '';

            $user->service = $services_info ?? '';
            $user->service_en = $services_info_en ?? '';
            $user->service_laos = $services_info_laos ?? '';

            $user->service_price = $service_price ?? '';
            $user->service_price_en = $service_price_en ?? '';
            $user->service_price_laos = $service_price_laos ?? '';

            $user->time_working_1 = $time_working_1;
            $user->time_working_2 = $time_working_2;
            $user->apply_for = $apply_for;

            $user->workplace = $workspace ?? '';

            $user->department_id = $department_id;

            $user->prescription = $prescription ? (int)$prescription : 0;
            $user->free = $free ? (int)$free : 0;
            $user->abouts = $abouts ?? '';
        }

        if ($member == Role::NORMAL_PEOPLE || $member == Role::PAITENTS) {
            $user->medical_history = $medical_history;
        }

        $user->email = $email;
        $user->avt = $thumbnail ?? asset('img/avt_default.jpg');
        $user->name = $name_user ?? '';
        $user->last_name = $last_name ?? '';
        $user->username = $username;
        if (!$isUpdate) {
            $user->password = Hash::make($password);
        }
        $user->phone = $phone;
        $user->detail_address = $detail_address;
        $user->detail_address_en = $detail_address_en;
        $user->detail_address_laos = $detail_address_laos;
        $user->province_id = $province_id;
        $user->district_id = $district_id;
        $user->commune_id = $commune_id;
        $user->address_code = $address_code ?? '';
        $user->type = $type;
        $user->member = $member;
        $user->abouts = 'default';
        $user->abouts_en = 'default';
        $user->abouts_lao = 'default';
        $user->status = $status ?? UserStatus::ACTIVE;
        return $this->returnArray(200, $user);
    }

    private function returnArray($status, $data)
    {
        $myArray['status'] = $status;
        $myArray['data'] = $data;
        return $myArray;
    }

    private function returnMessage($message)
    {
        return (new MainApi())->returnMessage($message);
    }

    public function update($id, Request $request)
    {
        try {
            $user = User::find($id);
            if (!$user || $user->status == UserStatus::DELETED) {
                return response($this->returnMessage('User not found!'), 404);
            }

            $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
            $isAdmin = false;
            if ($role_user) {
                $role = \App\Models\Role::find($role_user->role_id);
                if ($role->name == Role::ADMIN) {
                    $isAdmin = true;
                }
            }
            if ($isAdmin) {
                return response($this->returnMessage('Permission denied! Unable to access account information!'), 400);
            }

            $array = $this->saveUser($request, $user);
            if ($array['status'] == 200) {
                $success = $user->save();
                if ($success) {
                    return response()->json($user);
                }
                return response($this->returnMessage('Error, Update error!'), 400);
            } else {
                return response($this->returnMessage($array['data']), $array['status']);
            }
        } catch (\Exception $exception) {
            return response($this->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            if (!$user || $user->status == UserStatus::DELETED) {
                return response($this->returnMessage('User not found!'), 404);
            }

            $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
            $isAdmin = false;
            if ($role_user) {
                $role = \App\Models\Role::find($role_user->role_id);
                if ($role->name == Role::ADMIN) {
                    $isAdmin = true;
                }
            }
            if ($isAdmin) {
                return response($this->returnMessage('Permission denied! Cannot delete account!'), 400);
            }

            $user->status = UserStatus::DELETED;
            $success = $user->save();
            if ($success) {
                return response($this->returnMessage('Delete success!'), 200);
            }
            return response($this->returnMessage('Error, Delete error!'), 400);
        } catch (\Exception $exception) {
            return response($this->returnMessage('Error, Please try again!'), 400);
        }
    }
}
