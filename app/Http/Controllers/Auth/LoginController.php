<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
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
                return response("User not found!", 404);
            } else {
                if ($user && $user->status == UserStatus::INACTIVE) {
                    return response("User not active!", 400);
                } else if ($user && $user->status == UserStatus::BLOCKED) {
                    return response("User has been blocked!", 400);
                }
            }

            $existToken = $user->token;
            if ($existToken ) {
                try {
                    $user = JWTAuth::setToken($existToken)->toUser();
                    return response('The account is already logged in elsewhere!', 400);
                } catch (Exception $e) {
                    if (Auth::attempt($credentials)) {
                        $token = JWTAuth::fromUser($user);
                        $user->token = $token;
                        $user->save();
                        $response = $user->toArray();
                        $roleUser = RoleUser::where('user_id', $user->id)->first();
                        $role = Role::find($roleUser->role_id);
                        $response['role'] = $role->name;
                        $response['accessToken'] = $token;
                        return response()->json($response);
                    }
                }
            } else {
                $user->token = JWTAuth::fromUser($user);
                $user->save();
            }
            return response()->json($user);
        } catch (\Exception $exception) {
            return response("Login error!", 400);
        }
    }


    public function logout(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $user = User::find($user_id);
            $user->token = null;
            $user->save();
            return response('Logout success!', 200);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
