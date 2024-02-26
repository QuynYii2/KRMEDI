<?php

namespace App\Http\Controllers\restapi;

use App\Enums\Constants;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserApi extends Controller
{
    public function getUserByPoint(Request $request)
    {
        $sort_by = $request->input('sort_by') ?? 'desc';
        $admin = Role::where('name', \App\Enums\Role::ADMIN)->first();
        $role_admin = DB::table('role_users')->where('role_id', $admin->id)->get();
        $array_id = [];
        foreach ($role_admin as $item) {
            $array_id[] = $item->user_id;
        }
        $users = User::where('status', '!=', UserStatus::DELETED)
//            ->whereNotIn('id', $array_id)
            ->orderBy('points', $sort_by)
            ->get();
        return response()->json($users);
    }

    public function changePassword(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $user = User::find($userID);
            if ($userID && $user && $user->status == UserStatus::ACTIVE) {
                $oldPassword = $user->password;
                $currentPassword = $request->input('current_password');
                $newPassword = $request->input('new_password');
                $newPasswordConfirm = $request->input('new_password_confirm');

                $check = Hash::check($currentPassword, $oldPassword);
                if ($check) {
                    if ($newPassword != $newPasswordConfirm) {
                        return response((new MainApi())->returnMessage('New password or new password confirm incorrect!'), 400);
                    }

                    if (strlen($newPassword) < 5) {
                        return response((new MainApi())->returnMessage('Password invalid!'), 400);
                    }

                    $user->password = Hash::make($newPassword);
                    $success = $user->save();
                    if ($success) {
                        return response((new MainApi())->returnMessage('Change password success!'), 200);
                    }
                    return response((new MainApi())->returnMessage('Change password error'), 400);
                } else {
                    return response((new MainApi())->returnMessage('Password incorrect'), 400);
                }
            }
            return response((new MainApi())->returnMessage('User not found'), 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function changeEmail(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $email = $request->input('email');
            $user = User::find($userID);

            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                return response('Email invalid!', 400);
            }

            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                return response('Email already exited!', 400);
            }

            if ($userID && $user && $user->status == UserStatus::ACTIVE) {
                $user->email = $email;
                $success = $user->save();
                if ($success) {
                    return response('Change Email success!', 200);
                }
                return response('Change Email error', 400);
            }
            return response('User not found', 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function changePhoneNumber(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $phoneNumber = $request->input('phone_number');
            $user = User::find($userID);
            if ($userID && $user && $user->status == UserStatus::ACTIVE) {
                $user->phone = $phoneNumber;
                $success = $user->save();
                if ($success) {
                    return response('Change PhoneNumber success!', 200);
                }
                return response('Change PhoneNumber error', 400);
            }
            return response('User not found', 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function changeInformation(Request $request)
    {
        try {
            $userID = $request->input('user_id');

            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $username = $request->input('username');
            $address_code = $request->input('address_code');

            $user = User::find($userID);
            if ($userID && $user && $user->status == UserStatus::ACTIVE) {

                $user->name = $name;
                $user->last_name = $last_name;
//                $user->username = $username;
                $user->address_code = $address_code;

                $success = $user->save();
                if ($success) {
                    return response('Change Information success!', 200);
                }
                return response('Change Information error', 400);
            }
            return response('User not found', 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function changeAvt(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $user = User::find($userID);
            if ($userID && $user && $user->status == UserStatus::ACTIVE) {
                if ($request->hasFile('avatar')) {
                    $item = $request->file('avatar');
                    $itemPath = $item->store('user/avt', 'public');
                    $thumbnail = asset('storage/' . $itemPath);
                } else {
                    $thumbnail = $user->avt;
                }

                $user->avt = $thumbnail;
                $success = $user->save();
                if ($success) {
                    return response((new MainApi())->returnMessage('Change Avatar success!'), 200);
                }
                return response((new MainApi())->returnMessage('Change Avatar error'), 400);
            }
            return response((new MainApi())->returnMessage('User not found'), 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $userID = $request->input('user_id');

            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $username = $request->input('username');

            $email = $request->input('email');
            $medical_history = $request->input('medical_history');
            $phone_number = $request->input('phone_number');
            $current_password = $request->input('current_password');
            $new_password = $request->input('new_password');
            $confirm_password = $request->input('confirm_password');

            $nation_id = $request->input('nation_id');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');

            $gender = $request->input('gender');
            $birthday = $request->input('birthday');

            $user = User::find($userID);

            if ($userID && $user && $user->status == UserStatus::ACTIVE) {
                $user->name = $name;
                $user->last_name = $last_name;

                if ($user->email != $email) {
                    $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
                    if (!$isEmail) {
                        return response((new MainApi())->returnMessage('Email invalid!'), 400);
                    }

                    $oldUser = User::where('email', $email)->first();
                    if ($oldUser) {
                        return response((new MainApi())->returnMessage('Email already exited!'), 400);
                    }
                    $user->email = $email;
                }

                if ($user->username != $username) {
                    $oldUser = User::where('username', $username)->first();
                    if ($oldUser) {
                        return response((new MainApi())->returnMessage('Username already exited!'), 400);
                    }
                    $user->username = $username;
                }
                $user->phone = $phone_number;
                $user->medical_history = $medical_history;

                if ($current_password || $new_password || $confirm_password) {
                    $oldPassword = $user->password;
                    $check = Hash::check($current_password, $oldPassword);
                    if (!$check) {
                        return response((new MainApi())->returnMessage('Password incorrect'), 400);
                    }
                    if (strlen($new_password) < 5) {
                        return response((new MainApi())->returnMessage('Password invalid!'), 400);
                    }
                    if ($new_password != $confirm_password) {
                        return response((new MainApi())->returnMessage('New password or new password confirm incorrect'), 400);
                    }
                    $user->password = Hash::make($new_password);
                }

                $user->nation_id = $nation_id;
                $user->province_id = $province_id;
                $user->district_id = $district_id;
                $user->commune_id = $commune_id;

                $user->gender = $gender;
                $user->birthday = $birthday;

                $success = $user->save();
                if ($success) {
                    return response((new MainApi())->returnMessage('Change Information success!'), 200);
                }
                return response((new MainApi())->returnMessage('Change Information error'), 400);
            }
            return response((new MainApi())->returnMessage('User not found'), 404);
        } catch (\Exception $exception) {
            return response($exception, 500);
        }
    }

    /* Temporary function */
    public function logout()
    {
        User::where('token', '!=', null)->update(['token' => null]);
        return response('Logout done!', 200);
    }

    public function calcPoint(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        if (!$user) {
            return response('User not found!', 404);
        }
        $key__ = $request->input('key');
        $point = $request->input('point');
        if ($key__ == Constants::KEY_PROJECT) {
            $user->points = $point;
            $user->save();
            return response('Success!', 200);
        }
        return response('Key?', 201);
    }
}
