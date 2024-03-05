<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $loginRequest = $request->input('login_request');
            $password = $request->input('password');

            $credentials = [
                'email' => $loginRequest,
                'password' => $password,
            ];

            $user = User::where('email', $loginRequest)->first();
            if (!$user) {
                return response($this->returnMessage('User not found!'), 404);
            } else {
                if ($user && $user->status == UserStatus::INACTIVE) {
                    return response($this->returnMessage('User not active!'), 400);
                } else if ($user && $user->status == UserStatus::BLOCKED) {
                    return response($this->returnMessage('User has been blocked!'), 400);
                } else if ($user && $user->status == UserStatus::PENDING) {
                    return response($this->returnMessage('User not approve!'), 400);
                }
            }

            $existToken = $user->token;
            if ($existToken) {
                try {
                    $user = JWTAuth::setToken($existToken)->toUser();
                    return response($this->returnMessage('The account is already logged in elsewhere!'), 400);
                } catch (Exception $e) {

                }
            }

            (new MainController())->removeCouponExpiredAndAddCouponActive();

            if (Auth::attempt($credentials)) {
                $token = JWTAuth::fromUser($user);
                $user->token = $token;
                $user->save();

                if ($user->points > 1000) {
                    (new MainController())->setCouponForUser($user->id);
                }

                $response = $user->toArray();
                $roleUser = RoleUser::where('user_id', $user->id)->first();
                $role = Role::find($roleUser->role_id);
                $response['role'] = $role->name;
                $response['accessToken'] = $token;
                return response()->json($response);
            }
            return response()->json($this->returnMessage('Login fail! Please check email or password'), 400);
        } catch (\Exception $exception) {
            return response($this->returnMessage('Login error!'), 400);
        }
    }

    public function returnMessage($message)
    {
        return ['message' => $message];
    }

    public function logout(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $user = User::find($user_id);
            if ($user->token && $user->token != '') {
                (new MainController())->parsedToken($user->token);
            }
            $user->token = null;
            $user->token_firebase = null;
            $user->save();
            (new MainController())->removeCouponExpiredAndAddCouponActive();
            return response($this->returnMessage('Logout success!'), 200);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function saveTokenFireBase(Request $request)
    {
        try {
            $token = $request->input('token_firebase');
            $user_id = $request->input('user_id');

            $user = User::find($user_id);

            if (!$user || $user->status == UserStatus::DELETED) {
                return response($this->returnMessage('User not found!'), 400);
            }

            if ($user->status == UserStatus::BLOCKED) {
                return response($this->returnMessage('User have blocked!'), 400);
            }

            if ($user->status == UserStatus::INACTIVE) {
                return response($this->returnMessage('User not active!'), 400);
            }

            $user->token_firebase = $token;
            $user->save();

            return response()->json($user);
        } catch (\Exception $exception) {
            return response($this->returnMessage($exception->getMessage()), 400);
        }
    }
}
