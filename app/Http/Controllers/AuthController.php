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
        $validator = Validator::make($request->all(), [
            'email' => ['email', 'unique:users,email'],
            'password' => ['string', new NoSpacesRule],
            'passwordConfirm' => ['string', 'same:password', new NoSpacesRule],
            'phone' => [
                'required',
                'regex:/^0[3|5|7|8|9][0-9]{8}$/',
                'unique:users,phone'
            ],
        ],[
            'phone.unique' => 'Số điện thoại đã tồn tại'  // Custom message for the phone field
        ]);

        $password = $request->input('password');
        $passwordConfirm = $request->input('passwordConfirm');
        if ($password != $passwordConfirm) {
            toast('Mật khẩu khác nhau!', 'error', 'top-left');
            return back();
        }
        if (strlen($password) < 5) {
            toast('Password invalid!', 'error', 'top-left');
            return back();
        }
        if ($validator->fails()) {
            if ($validator->errors()->has('phone')) {
                toast($validator->errors()->first('phone'), 'error', 'top-left');
            } else {
                toast($validator->errors()->first(), 'error', 'top-left');
            }
            return back();
        }

        $type = $request->input('type');
        $userData = $request->except(['fileupload', 'passwordConfirm']);
        $userData['password'] = $request->input('password');
        $checkPending = false;

        if ($type == \App\Enums\Role::BUSINESS) {
            if (!$request->hasFile('fileupload')) {
                toast('Cần up file giấy phép kinh doanh', 'error', 'top-left');
                return back();
            }
            $item = $request->file('fileupload');
            $itemPath = $item->store('license', 'public');
            $img = asset('storage/' . $itemPath);
            $userData['business_license_img'] = $img;  // Store the image path in user data
            $checkPending = true;
        }
        if ($type == \App\Enums\Role::MEDICAL) {
            if (!$request->hasFile('fileupload')) {
                toast('Cần up file giấy phép hành nghề', 'error', 'top-left');
                return back();
            }
            $item = $request->file('fileupload');
            $itemPath = $item->store('license', 'public');
            $img = asset('storage/' . $itemPath);
            $userData['medical_license_img'] = $img;
            $checkPending = true;
        }

        if ($checkPending) {
            $userData['status'] = UserStatus::PENDING;
        } else {
            $userData['status'] = UserStatus::ACTIVE;
        }

        $invite_code = $request->input('inviteCode') ?? "";
        $userData['invite_code'] = $invite_code;
        $userData['member'] = $request->input('member');

        // Store all user data, including the business license image, in session
        session([
            'user_data' => $userData,
            'otp_verification' => false  // Initially false, will be set true upon successful OTP send
        ]);

        // Assume sendOTPSMS method handles sending the OTP and returns a boolean status
        if ($this->sendOTPSMS($request->input('phone'))) {
            session(['otp_verification' => true]);
            return redirect()->route('home')->withToastSuccess('OTP sent successfully. Please verify.');
        }

        return back()->withToastError('Failed to send OTP. Please try again.');
    }

    public function appSendOtp(Request $request)
    {
        $phone = $request->get('phone');
        $userData['phone']=$phone;
        session([
            'user_data' => $userData,
            'otp_verification' => false
        ]);
        $sms = new SendSMSController();
        $otp = random_int(100000, 999999);
        $provider = $this->getNetworkProvider($phone);

        if ($provider === 'viettel') {
            $content = "Ma OTP dang ky tai khoan IL VIETNAM cua ban la: " . $otp;
        } else {
            $content = "IL VIETNAM: Ma OTP dang ky tai khoan https://krmedi.vn/ cua ban la: " . $otp;
        }

        // lưu cache otp 5 phút
        $key = 'otp_' . $phone;
        $expiresAt = now()->addMinutes(5);
        Cache::put($key, $otp, $expiresAt);

        $data =  $sms->sendSMS(1, $phone, $content);
        if ($data){
            return response()->json(['message' => 'OTP sent successfully. Please verify.','status'=>true]);
        }
        return response()->json(['message' => 'Failed to send OTP. Please try again.','status'=>false]);
    }

    public function appVerifyOtp(Request $request)
    {
        $otpCache = Cache::get('otp_' . $request->session()->get('user_data')['phone']);

        if (!$otpCache || $otpCache != $request->get('otp')) {
            return response()->json(['message' => 'Invalid or expired OTP.','status'=>false]);
        }
        session()->forget(['user_data', 'otp_verification']);
        return response()->json(['message' => 'check OTP successfully.','status'=>true]);
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

//            $existToken = $user->token;
//            if ($existToken) {
//                try {
//                    $user = JWTAuth::setToken($existToken)->toUser();
//                    toast('Tài khoản đang được đăng nhập ở một thiết bị khác!', 'error', 'top-left');
//                    return back()->withInput();
//                } catch (Exception $e) {
//                }
//            }

            if (Auth::attempt($credentials)) {
                $token = JWTAuth::fromUser($user);
                $user->token = $token;
                $user->devices_name = 'web';
                $user->save();
                $expiration_time = time() + 86400;
                setCookie('accessToken', $token, $expiration_time, '/');
                toast('Welcome ' . $user->email, 'success', 'top-left');

                if ($user->points >= 1000) {
                    (new MainController())->setCouponForUser($user->id);
                }

                $role_user = DB::table('role_users')->where('user_id', $user->id)->first();
                $roleNames = Role::where('id', $role_user->role_id)->pluck('name');
                if (session()->has('booking_data')) {
                    $bookingData = session()->get('booking_data');
                    $createdAt = \Carbon\Carbon::parse($bookingData['created_at']);
                    if ($createdAt->diffInMinutes(now()) <= 5) {
                        $this->processBooking($bookingData['clinic_id'], Auth::user());
                        alert('Đặt lịch khám thành công');
                    }
                    session()->forget('booking_data');
                }
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
            Auth::logout();
        }
        (new MainController())->removeCouponExpiredAndAddCouponActive();
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

    private function getNetworkProvider($phoneNumber)
    {
        // Example prefixes for Viettel and other providers
        $viettelPrefixes = ['098', '097', '096', '086', '032', '033', '034', '035', '036', '037', '038', '039'];
        $prefix = substr($phoneNumber, 0, 3);

        if (in_array($prefix, $viettelPrefixes)) {
            return 'viettel';
        }

        return 'other';
    }

    private function sendOTPSMS($value)
    {
        $sms = new SendSMSController();
        $otp = random_int(100000, 999999);
        $provider = $this->getNetworkProvider($value);

        if ($provider === 'viettel') {
            $content = "Ma OTP dang ky tai khoan IL VIETNAM cua ban la: " . $otp;
        } else {
            $content = "IL VIETNAM: Ma OTP dang ky tai khoan https://krmedi.vn/ cua ban la: " . $otp;
        }

        // lưu cache otp 5 phút
        $key = 'otp_' . $value;
        $expiresAt = now()->addMinutes(5);
        Cache::put($key, $otp, $expiresAt);

        return $sms->sendSMS(1, $value, $content);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $otpCache = Cache::get('otp_' . $request->session()->get('user_data')['phone']);

        if (!$otpCache || $otpCache != $request->input('otp')) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // OTP is valid, retrieve user data from session
        $userData = session('user_data');
        $user = new User($userData);
        $user-> name = '';
        $user-> abouts = '';
        $user-> abouts_en = '';
        $user-> abouts_lao = '';
        $user-> password = Hash::make($userData['password']);  // Ensure password is hashed
        $user-> token = $userData['_token'];
        $member = $request->session()->get('user_data')['member'];
        $user->member = $member;
        $invite_code = $userData['invite_code'];
        $identify_number = Str::random(8);
        while (User::where('identify_number', $identify_number)->exists()) {
            $identify_number = Str::random(8);
        }
        $user->identify_number = $identify_number;

        if ($user->save()) {
            $role = Role::where('name', $member)->first();
            $newUser = User::where('phone', $request->session()->get('user_data')['phone'])->first();
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

            if ($invite_code) {
                $getUserInvite = User::where('identify_number', $identify_number)->first();

                $getUserInvite->points = $getUserInvite->points + 1;
                $getUserInvite->save();
            }

            if($userData['type'] == \App\Enums\Role::MEDICAL) {
                $user->medical_license_img = $userData['medical_license_img'];
                $user->status = $userData['status'];
            }elseif ($userData['type'] == \App\Enums\Role::BUSINESS){
                $user->business_license_img = $userData['business_license_img'];
                $user->status = $userData['status'];
                $openDate = $request->input('open_date', '00:00');
                $closeDate = $request->input('close_date', '23:59');
                $currentDate = Carbon::now();
                $openDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $openDate);
                $closeDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $closeDate);
                $formattedOpenDateTime = $openDateTime->format('Y-m-d\TH:i');
                $formattedCloseDateTime = $closeDateTime->format('Y-m-d\TH:i');
                $latitude = $request->input('latitude', '0.0');
                $longitude = $request->input('longitude', '0.0');

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
            }

            session()->put('user_id', $user->id);
            auth()->login($user, true);
            session()->forget(['user_data', 'otp_verification']);

            session()->put('show_modal', true);
            if (session()->has('booking_data')) {
                $bookingData = session()->get('booking_data');
                $createdAt = \Carbon\Carbon::parse($bookingData['created_at']);
                if ($createdAt->diffInMinutes(now()) <= 5) {
                    $this->processBooking($bookingData['clinic_id'], Auth::user());
                    alert('Đặt lịch khám thành công');
                }
                session()->forget('booking_data');
            }

            return redirect()->route('home')->withToastSuccess('Registration successful and user logged in.');
        }
        return back()->withToastError('Failed to register user. Please try again.');
    }

    public function updateUserOnline(Request $request){
        $userId = $request->get('user_id');
        $isOnline = $request->get('is_online');

        $user = User::find($userId);
        if ($user) {
            $user->is_online = $isOnline;
            $user->save();
        }

        return response()->json(['status' => 'update user success']);
    }

}
