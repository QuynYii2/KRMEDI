<?php

namespace App\Http\Controllers;

use App\Enums\ClinicStatus;
use App\Enums\UserStatus;
use App\Models\Clinic;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthSocialController extends Controller
{
    public function getGoogleSignInUrl()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                ->redirect()->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if ($googleUser->getEmail() == null || $googleUser->getName() == null) {
                return redirect()->route('login')->with('error', 'Error');
            }

            $existingUser = User::where('email', $googleUser->email)->first();

            $password = (new MainController())->generateRandomString(8);
            $passwordHash = Hash::make($password);

            if ($existingUser) {
                auth()->login($existingUser, true);
                $token = JWTAuth::fromUser($existingUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
                if (!$existingUser->provider_name) {
                    return redirect(route('profile'));
                }
            } else {
                $newUser = new User;
                $newUser->provider_name = "google";
                $newUser->provider_id = $googleUser->getId();
                $newUser->name = $googleUser->getName();
                $newUser->last_name = $googleUser->getName();
                $newUser->email = $googleUser->getEmail();
                $newUser->phone = '';
                $newUser->username = $googleUser->getId() . $googleUser->getEmail();
                $newUser->address_code = "";
                $newUser->password = $passwordHash;
                $newUser->type = "OTHERS";
                $newUser->email_verified_at = now();
                $newUser->avt = $googleUser->getAvatar();

                $newUser->abouts = '';
                $newUser->abouts_en = '';
                $newUser->abouts_lao = '';

                $newUser->save();

                auth()->login($newUser, true);
                $token = JWTAuth::fromUser($newUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
            }
            toast('Register success!', 'success', 'top-left');
            return redirect()->route('login.social.choose.role');
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function getFacebookSignInUrl()
    {
        try {
            $url = Socialite::driver('facebook')
                ->stateless()
                ->redirect()
                ->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginFacebookCallback(Request $request)
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            if ($facebookUser->getEmail() == null || $facebookUser->getName() == null) {
                return redirect()->route('login')->with('error', 'Error');
            }

            $existingUser = User::where('email', $facebookUser->email)->first();

            $password = (new MainController())->generateRandomString(8);
            $passwordHash = Hash::make($password);

            if ($existingUser) {
                auth()->login($existingUser, true);
                $token = JWTAuth::fromUser($existingUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
                if (!$existingUser->provider_name) {
                    return redirect(route('profile'));
                }
            } else {
                $newUser = new User;
                $newUser->provider_name = "facebook";
                $newUser->provider_id = $facebookUser->getId();
                $newUser->name = $facebookUser->getName();
                $newUser->last_name = $facebookUser->getName();
                $newUser->email = $facebookUser->getEmail();
                $newUser->phone = '';
                $newUser->username = $facebookUser->getId() . $facebookUser->getEmail();
                $newUser->address_code = "";
                $newUser->password = $passwordHash;
                $newUser->type = "OTHERS";
                $newUser->email_verified_at = now();
                $newUser->avt = $facebookUser->getAvatar();

                $newUser->abouts = '';
                $newUser->abouts_en = '';
                $newUser->abouts_lao = '';

                $newUser->save();

                auth()->login($newUser, true);
                $token = JWTAuth::fromUser($newUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
            }

            toast('Register success!', 'success', 'top-left');
            return redirect()->route('login.social.choose.role');
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function getKakaoSignInUrl()
    {
        try {
            $url = Socialite::driver('kakao')
                ->stateless()
                ->redirect()
                ->getTargetUrl();
            return redirect($url);
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginKakaoCallback(Request $request)
    {
        try {
            $kakaoUser = Socialite::driver('kakao')->stateless()->user();


            if ($kakaoUser->getEmail() == null || $kakaoUser->getName() == null) {
                return redirect()->route('login')->with('error', 'Error');
            }

            $existingUser = User::where('email', $kakaoUser->email)->first();

            $password = (new MainController())->generateRandomString(8);
            $passwordHash = Hash::make($password);

            if ($existingUser) {
                auth()->login($existingUser, true);
                $token = JWTAuth::fromUser($existingUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
                if (!$existingUser->provider_name) {
                    return redirect(route('profile'));
                }
            } else {
                $newUser = new User;
                $newUser->provider_name = "facebook";
                $newUser->provider_id = $kakaoUser->getId();
                $newUser->name = $kakaoUser->getName();
                $newUser->last_name = $kakaoUser->getName();
                $newUser->email = $kakaoUser->getEmail();
                $newUser->phone = '';
                $newUser->username = $kakaoUser->getId() . $kakaoUser->getEmail();
                $newUser->address_code = "";
                $newUser->password = $passwordHash;
                $newUser->type = "OTHERS";
                $newUser->email_verified_at = now();
                $newUser->avt = $kakaoUser->getAvatar();

                $newUser->abouts = '';
                $newUser->abouts_en = '';
                $newUser->abouts_lao = '';

                $newUser->save();

                auth()->login($newUser, true);
                $token = JWTAuth::fromUser($newUser);
                setcookie("accessToken", $token, time() + 3600 * 24);
            }

            toast('Register success!', 'success', 'top-left');
            return redirect()->route('login.social.choose.role');
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function chooseRole(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('auth.social-choose-role', compact('user'));
        }
        return view('layouts.error.not-found');
    }

    public function saveUser(Request $request)
    {
        try {
            $user = Auth::user();
            /* All role */
            $name = $request->input('name');
            $lastname = $request->input('last_name');
            $phone = $request->input('phone');
            $address_code = $request->input('address_code');
            /* Info user */
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $member = $request->input('member');
            $type = $request->input('type');

            /* Only for role medical */
            $doctor_name = $request->input('doctor_name');
            $doctor_phone = $request->input('doctor_phone');
            $experience = $request->input('experience');
            $doctor_hospital = $request->input('doctor_hospital');
            $specialized_services = $request->input('specialized_services');
            $services_info = $request->input('services_info');

            /* Only for role business */
            $open_date = $request->input('open_date');
            $close_date = $request->input('close_date');
            $time_work = $request->input('time_work') ?? 'ALL';
            $address = $request->input('address');
            $representative = $request->input('representative');

            $prescription = $request->input('prescription') ?? 0;
            $free = $request->input('free') ?? 0;

            /* More role other */
            $checkPending = false;
            if ($type != \App\Enums\Role::NORMAL) {
                if (!$request->hasFile('file_upload')) {
                    toast('Please upload your license ', 'error', 'top-left');
                    return back();
                }
                $item = $request->file('file_upload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->medical_license_img = $img;
                $checkPending = true;
            }

            if ($checkPending) {
                $user->status = UserStatus::PENDING;
            } else {
                $user->status = UserStatus::ACTIVE;
            }

            /* Handle logic code */
            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                toast('Error, Email invalid!', 'error', 'top-left');
                return back();
            }

            if ($username != Auth::user()->username) {
                $oldUser = User::where('username', $username)->first();
                if ($oldUser) {
                    toast('Error, Username already exited!', 'error', 'top-left');
                    return back();
                }
            }

            if ($email != Auth::user()->email) {
                $oldUser = User::where('email', $email)->first();
                if ($oldUser) {
                    toast('Error, Email already exited!', 'error', 'top-left');
                    return back();
                }
            }

            if ($password != $passwordConfirm) {
                toast('Error, Password or Password Confirm incorrect!', 'error', 'top-left');
                return back();
            }

            if (strlen($password) < 5) {
                toast('Error, Password invalid!', 'error', 'top-left');
                return back();
            }

            $user->provider_name = '';
            $user->provider_id = '';
            $user->name = $name;
            $user->last_name = $lastname;
            $user->email = $email;
            $user->phone = $phone;
            $user->username = $username;
            $user->address_code = $address_code;
            $user->password = Hash::make($password);

            $user->type = $type;
            $user->member = $member;

            /* Value member medical */
            if ($type == \App\Enums\Role::MEDICAL) {
                $user->name = $doctor_name;
                $user->phone = $doctor_phone;
                $user->year_of_experience = $experience ?? '';
                $user->hospital = $doctor_hospital ?? '';
                $user->specialty = $specialized_services ?? '';
                $user->service = $services_info ?? '';
                $user->prescription = $prescription;
                $user->free = $free;
            }

            $success = $user->save();

            /* Value member business */
            $currentDate = Carbon::now();
            if ($type == \App\Enums\Role::BUSINESS) {
                $openDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $open_date);
                $closeDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $close_date);

                $clinic = new Clinic();

                $formattedOpenDateTime = $openDateTime->format('Y-m-d\TH:i');
                $formattedCloseDateTime = $closeDateTime->format('Y-m-d\TH:i');

                $clinic->address_detail = $address;
                $clinic->address = $address;

                $clinic->name = $representative;
                $clinic->open_date = $formattedOpenDateTime ?? '';
                $clinic->close_date = $formattedCloseDateTime ?? '';
                $clinic->experience = $experience;
                $clinic->user_id = $user->id;
                $clinic->gallery = $user->avt;
                $clinic->time_work = $time_work;
                $clinic->status = ClinicStatus::ACTIVE;
                $clinic->representative_doctor = $representative;
                $clinic->type = $member;
                $clinic->save();

                $user->detail_address = $address;
                $user->year_of_experience = $experience;
                $user->bac_si_dai_dien = $representative;
                $user->name = $name;
                $user->save();
            }

            if ($success) {
                $role = Role::where('name', $member)->first();

                if (!$role) {
                    $role = Role::where('name', \App\Enums\Role::PAITENTS)->first();
                }

                RoleUser::create([
                    'role_id' => $role->id,
                    'user_id' => $user->id
                ]);

                toast('Update success!', 'success', 'top-left');
                return redirect()->route('home');
            }
            toast('Register error!', 'error', 'top-left');
            return back();
        } catch (\Exception $exception) {
            toast('Error, Please try again!', 'error', 'top-left');
            return back();
        }
    }
}
