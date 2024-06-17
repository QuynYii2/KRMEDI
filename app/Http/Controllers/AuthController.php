<?php

namespace App\Http\Controllers;

use App\Enums\ClinicStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Clinic;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Rules\NoSpacesRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['email', 'unique:users,email'],
                'username' => ['string', 'unique:users,username', new NoSpacesRule],
                'password' => ['string', new NoSpacesRule],
                'passwordConfirm' => ['string', 'same:password', new NoSpacesRule],
                'member' => ['nullable', 'string'],
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
                'name_doctor' => ['nullable'],
                'contact_phone' => ['nullable', 'unique:users,phone', 'regex:/^0[1-9][0-9]{8}$/'],
                'experience' => ['nullable', 'integer'],
                'hospital' => ['nullable', 'string'],
                'specialized_services' => ['nullable', 'string'],
                'services_info' => ['nullable', 'string'],
                'identifier' => ['nullable'],
                'prescription' => ['nullable'],
                'free' => ['nullable'],
                'signature' => ['nullable'],
                'phone' => ['required', 'regex:/^0[3|5|7|8|9][0-9]{8}$/'],
            ]);

            if ($validator->fails()) {
                toast($validator->errors()->first(), 'error', 'top-left');
                return back();
            }

            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $member = $request->input('member');
            $medical_history = $request->input('medical_history');
            $type = $request->input('type');
            $openDate = $request->input('open_date', '00:00');
            $closeDate = $request->input('close_date', '23:59');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $address_detail = $request->input('address');
            $time_work = $request->input('time_work');
            $provider_name = $request->input('provider_name') ?? "";
            $provider_id = $request->input('provider_id') ?? "";
            $phone = $request->input('phone');
            $invite_code = $request->input('inviteCode') ?? "";

            $signature = $request->input('signature') ?? "";

            $identify_number = Str::random(8);
            while (User::where('identify_number', $identify_number)->exists()) {
                $identify_number = Str::random(8);
            }

            $address = $request->input('combined_address');
            $representative = $request->input('representative');
            $latitude = $request->input('latitude', '0.0');
            $longitude = $request->input('longitude', '0.0');
            $experienceHospital = $request->input('experienceHospital');
            if ($province_id && $district_id && $commune_id) {
                $province = explode('-', $province_id);
                $district = explode('-', $district_id);
                $commune = explode('-', $commune_id);
            }

            $currentDate = Carbon::now();


            $user = new User();

            $checkPending = false;

            $oldPhone = User::where('phone', $phone)->first();
            if ($oldPhone) {
                toast('Số điện thoại đã tồn lại!', 'error', 'top-left');
                return back();
            }

//            $oldUser = User::where('username', $username)->first();
//            if ($oldUser) {
//                toast('Username already exited!', 'error', 'top-left');
//                return back();
//            }
//
            if ($password != $passwordConfirm) {
                toast('Mật khẩu khác nhau!', 'error', 'top-left');
                return back();
            }

            if (strlen($password) < 5) {
                toast('Password invalid!', 'error', 'top-left');
                return back();
            }

            if ($type == \App\Enums\Role::BUSINESS) {
                /* kiểm tra xem fileupload có tồn tại không, nếu không thì thông báo lỗi */
                if (!$request->hasFile('fileupload')) {
                    toast('Cần up file giấy phép kinh doanh', 'error', 'top-left');
                    return back();
                }
                $item = $request->file('fileupload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->business_license_img = $img;
                $checkPending = true;
            }

            if ($type == \App\Enums\Role::MEDICAL) {
                /* kiểm tra xem fileupload có tồn tại không, nếu không thì thông báo lỗi */
                if (!$request->hasFile('fileupload')) {
                    toast('Cần up file giấy phép hành nghề', 'error', 'top-left');
                    return back();
                }
                $item = $request->file('fileupload');
                $itemPath = $item->store('license', 'public');
                $img = asset('storage/' . $itemPath);
                $user->medical_license_img = $img;
                $checkPending = true;
            }

            $passwordHash = Hash::make($password);

            $user->email = $email;
            if ($type == \App\Enums\Role::MEDICAL) {
                $name_doctor = $request->input('name_doctor');
                $experience = $request->input('experience');
                $hospital = $request->input('hospital');
                $specialized_services = $request->input('specialized_services');
                $services_info = $request->input('services_info');
                $user->name = $name_doctor;
                $user->identifier = $request->input('identifier');
                $user->phone = $phone;
                $user->year_of_experience = $experience ?? '0';
                $user->hospital = $hospital ?? '';
                $user->specialty = $specialized_services ?? '';
                $user->service = $services_info ?? '';
                $user->prescription = $request->has('prescription') ? (int)$request->input('prescription') : 0;
                $user->free = $request->has('free') ? (int)$request->input('free') : 0;
            } else {
                $user->name = '';
                $user->phone = $phone;
            }

            if ($member == \App\Enums\Role::NORMAL_PEOPLE || $member == \App\Enums\Role::PAITENTS) {
                $user->medical_history = $medical_history;
            }

            $user->name = '';
            $user->last_name = '';
            $user->password = $passwordHash;
            $user->username = $username;
            $user->address_code = '';
            $user->type = $type;
            $user->member = $member ?? '';
            $user->provider_id = $provider_id ?? null;
            $user->provider_name = $provider_name ?? null;
            $user->identify_number = $identify_number ?? null;
            $user->abouts = 'default';
            $user->abouts_en = 'default';
            $user->abouts_lao = 'default';

            if ($checkPending) {
                $user->status = UserStatus::PENDING;
            } else {
                $user->status = UserStatus::ACTIVE;
            }
            $success = $user->save();
            if ($success) {
                //Cộng điểm giới thiệu
                if ($invite_code) {
                    $getUserInvite = User::where('identify_number', $identify_number)->first();
                    $getUserInvite->points = $getUserInvite->points + 1;
                    $getUserInvite->save();
                }

                $role = Role::where('name', $member)->first();
                $newUser = User::where('phone', $phone)->first();
                if ($role) {
                    RoleUser::create([
                        'role_id' => $role->id,
                        'user_id' => $newUser->id
                    ]);
                } else {
                    $roleNormal = Role::where('name', \App\Enums\Role::PAITENTS)->first();
                    RoleUser::create([
                        'role_id' => $roleNormal->id,
                        'user_id' => $newUser->id
                    ]);
                }
//                (new MainController())->createRoleUser($member, $username);

                if ($user->type == \App\Enums\Role::MEDICAL) {
                    // Send OTP
                    $this->sendOTPSMS($request->input('phone'), $user);
                    session()->put('otp_verification', true);
                    session()->put('user_id', $user->id);
                    toast('Đăng ký thành công!', 'success', 'top-left');
                    return redirect()->route('home');
                }
                if ($user->type == \App\Enums\Role::BUSINESS) {
                    try {
                        $currentDate = Carbon::now();
                        $openDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $openDate);
                        $closeDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $closeDate);
                        $formattedOpenDateTime = $openDateTime->format('Y-m-d\TH:i');
                        $formattedCloseDateTime = $closeDateTime->format('Y-m-d\TH:i');

                        $hospital = new Clinic();
                        $hospital->address_detail = $request->input('address_detail', '');
                        $hospital->address = ',' . ($province[0] ?? '') . ',' . ($district[0] ?? '') . ',' . ($commune[0] ?? '');
                        $hospital->name = $request->input('representative', '');
                        $hospital->latitude = $latitude;
                        $hospital->longitude = $longitude;
                        $hospital->open_date = $formattedOpenDateTime;
                        $hospital->close_date = $formattedCloseDateTime;
                        $hospital->experience = $request->input('experienceHospital', '1');
                        $hospital->gallery = $request->input('img', '1');
                        $hospital->user_id = $user->id;
                        $hospital->time_work = $request->input('time_work', '');
                        $hospital->status = ClinicStatus::ACTIVE;
                        $hospital->type = $user->member;
                        $hospital->phone = $request->input('phone', '');
                        $hospital->representative_doctor = '';
                        $hospital->save();

                        $newUser = User::find($user->id);
                        $newUser->province_id = $province[0] ?? null;
                        $newUser->district_id = $district[0] ?? null;
                        $newUser->commune_id = $commune[0] ?? null;
                        $newUser->address_code = $province[2] ?? '1';
                        $newUser->detail_address = $request->input('address_detail', '');
                        $newUser->year_of_experience = $request->input('experienceHospital', '1');
                        $newUser->bac_si_dai_dien = $request->input('representative', '1');
                        $newUser->name = $request->input('representative', '1');
                        $newUser->save();

                        // Send OTP
                        $this->sendOTPSMS($request->input('phone'), $user);
                        // Redirect to OTP verification page
                        session()->put('otp_verification', true);
                        session()->put('user_id', $user->id);
                        toast('Đăng ký thành công!', 'success', 'top-left');
                        return redirect()->route('home');
                    } catch (\Exception $e) {
                        Log::error('Date format error: ' . $e->getMessage());
                        return redirect()->back()->withErrors(['error' => 'Đã có lỗi xảy ra trong quá trình đăng ký, vui lòng đảm bảo các thông tin đã được điền đầy đủ.']);
                    }
                }
                // Send OTP
                $this->sendOTPSMS($request->input('phone'), $user);
                // Redirect to OTP verification page
                session()->put('otp_verification', true);
                session()->put('user_id', $user->id);
                toast('Đăng ký thành công!', 'success', 'top-left');
                return redirect(route('home'));
            }
            toast('Đăng ký thất bại!', 'error', 'top-left');
            return back();
        } catch (Exception $exception) {
//            dd($exception->getMessage());
            toast('Đã có lỗi, vui lòng thử lại!', 'error', 'top-left');
            return back();
        }
    }

    public function login(Request $request)
    {
        try {
            $callback_url = $request->input('call_back_url');
            $loginRequest = $request->input('email');
            $password = $request->input('password');

            $credentials = [
                'password' => $password,
            ];

            // Check if the login request is a valid email address
            if (filter_var($loginRequest, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $loginRequest;
            } else {
                $credentials['phone'] = $loginRequest;
            }

            $user = User::where('email', $loginRequest)->orWhere('phone', $loginRequest)->first();
            if (!$user || !$loginRequest) {
                toast('Account not found!', 'error', 'top-left');
                return back();
            }

            switch ($user->status) {
                case UserStatus::ACTIVE:
                    break;
                case UserStatus::INACTIVE:
                    toast('Account not active!', 'error', 'top-left');
                    return back();
                case UserStatus::BLOCKED:
                    toast('Account has been blocked!', 'error', 'top-left');
                    return back();
                case UserStatus::DELETED:
                    toast('Account has been deleted!', 'error', 'top-left');
                    return back();
                case UserStatus::PENDING:
                    toast('Account is pending!', 'error', 'top-left');
                    return back();
            }

            (new MainController())->removeCouponExpiredAndAddCouponActive();

            $existToken = $user->token;
            if ($existToken) {
                try {
                    $user = JWTAuth::setToken($existToken)->toUser();
                    toast('Tài khoản đang được đăng nhập ở một thiết bị khác!', 'error', 'top-left');
                    return back()->withInput();
                } catch (Exception $e) {
                }
            }

            if (Auth::attempt($credentials)) {
                $token = JWTAuth::fromUser($user);
                $user->token = $token;
                $user->save();
                $expiration_time = time() + 86400;
                setCookie('accessToken', $token, $expiration_time, '/');
                toast('Welcome ' . $user->email, 'success', 'top-left');

                if ($user->points >= 1000) {
                    (new MainController())->setCouponForUser($user->id);
                }

                $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
                $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

                if ($callback_url) {
                    return redirect($callback_url);
                }

                if ($roleNames->contains('DOCTORS') || $roleNames->contains('PHAMACISTS') || $roleNames->contains('THERAPISTS') || $roleNames->contains('ESTHETICIANS') || $roleNames->contains('NURSES') || $roleNames->contains('PHARMACEUTICAL COMPANIES') || $roleNames->contains('HOSPITALS') || $roleNames->contains('CLINICS') || $roleNames->contains('PHARMACIES') || $roleNames->contains('SPAS') || $roleNames->contains('OTHERS') || $roleNames->contains('ADMIN')) {
                    return redirect(route('home'));
                }

                return redirect(route('home'));
            } else {
                toast('Email or password incorrect', 'error', 'top-left');
            }
            return back();
        } catch (Exception $exception) {
            toast('Error, Please try again!', 'error', 'top-left');
            return back();
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->token && $user->token != '') {
                (new MainController())->parsedToken($user->token);
            }
            $user->token = null;
            $user->token_firebase = null;
            $user->save();
            Cache::forget('user-is-online|' . $user->id);
        }
        (new MainController())->removeCouponExpiredAndAddCouponActive();
        Auth::logout();
        session()->forget('show_modal');
        setCookie('accessToken', null);
        return redirect('/');
    }

    public function setCookie($name, $value)
    {
        $minutes = 3600;
        $response = new Response('Set Cookie');
        $response->withCookie(cookie($name, $value, $minutes));
        return $response;
    }

    private function sendOTPSMS($value, $user)
    {
        $sms = new SendSMSController();
        $otp = random_int(100000, 999999);
        $content = "Ma OTP dang ky tai khoan IL VIETNAM cua ban la: " . $otp;
        // lưu cache otp 5 phút
        $key = 'otp_' . $user->id;
        $expiresAt = now()->addMinutes(5);
        Cache::put($key, $otp, $expiresAt);

        return $sms->sendSMS($user->id, $value, $content);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->input('user_id'));

        // Check OTP
        $key = 'otp_' . $user->id;
        $otpCache = Cache::get($key);

        if (!$otpCache) {
            session()->put('otp_verification', true);
            return redirect()->back()->withErrors(['otp' => 'OTP hết hạn, vui lòng yêu cầu một mã OTP khác.']);
        }

        if ($otpCache != $request->input('otp')) {
            session()->put('otp_verification', true);
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không chính xác.']);
        }

        // OTP is valid
        Cache::forget($key);

        // Log the user in
        auth()->login($user, true);
        $accessToken = Str::random(60);
        Cookie::queue('accessToken', $accessToken, 60);

        session()->put('show_modal', true);

        // Redirect to home or any other page
        toast('Đăng ký thành công!', 'success', 'top-left');
        return redirect()->route('home');
    }

}
