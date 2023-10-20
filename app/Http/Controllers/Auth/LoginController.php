<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
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

            if (Auth::attempt($credentials)) {
                $token = JWTAuth::fromUser($user);
                $response = $user->toArray();
                $response['accessToken'] = $token;
                return response()->json($response);
            }
            return response("Login fail!", 400);
        } catch (\Exception $exception) {
            return response("Login error!", 400);
        }
    }
}
