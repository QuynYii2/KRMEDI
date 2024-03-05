<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\Constants;
use App\Enums\CouponStatus;
use App\Enums\SocialUserStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\SocialUser;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainApi extends Controller
{
    public function returnMessage($message)
    {
        return ['message' => $message];
    }

    public function isAdmin($user_id)
    {
        $role_user = RoleUser::where('user_id', $user_id)->first();

        $roleNames = Role::where('id', $role_user->role_id)->pluck('name');

        if ($roleNames->contains('ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function handleToken()
    {
        $array_data = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $array_data['status'] = 200;
            $array_data['data'] = $user;
            return $array_data;
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $array_data['status'] = 444;
            $array_data['message'] = 'Token expired';
            return $array_data;
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $array_data['status'] = 400;
            $array_data['message'] = 'Token invalid';
            return $array_data;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $array_data['status'] = 400;
            $array_data['message'] = $e->getMessage();
            return $array_data;
        }
    }

    public function translateLanguage(Request $request)
    {
        try {
            $text = $request->input('text');
            $language = $request->input('language');

            $translate = new TranslateController();

            $translate_text = $translate->translateText($text, $language ?? 'vi');
            return response($translate_text);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function checkCoupon(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $coupon_id = $request->input('coupon_id');
            $exitCouponApply = \App\Models\CouponApply::where('user_id', $user_id)->where('coupon_id', $coupon_id)->first();
            $is_register = false;
            if ($exitCouponApply) {
                $is_register = true;
            }
            $user_social = SocialUser::where('user_id', $user_id)
                ->where('status', SocialUserStatus::ACTIVE)
                ->first();
            if (!$user_social) {
                return response($this->returnMessage('User social not found!'), 404);
            }

            $my_array = null;
            $instagram = $user_social->instagram ? $my_array[] = 'instagram' : 0;
            $facebook = $user_social->facebook ? $my_array[] = 'facebook' : 0;
            $tiktok = $user_social->tiktok ? $my_array[] = 'tiktok' : 0;
            $youtube = $user_social->youtube ? $my_array[] = 'youtube' : 0;
            $google = $user_social->google_review ? $my_array[] = 'google_review' : 0;

            $coupon = Coupon::find($coupon_id);

            if (!$coupon || $coupon->status == CouponStatus::DELETED) {
                return response($this->returnMessage('Coupon not found!'), 404);
            }

            if ($coupon->status != CouponStatus::ACTIVE) {
                return response($this->returnMessage('Coupon was expired!'), 404);
            }

            $your_array = null;
            $instagram = $coupon->is_instagram == 1 ? $your_array[] = 'instagram' : 0;
            $facebook = $coupon->is_facebook == 1 ? $your_array[] = 'facebook' : 0;
            $tiktok = $coupon->is_tiktok == 1 ? $your_array[] = 'tiktok' : 0;
            $youtube = $coupon->is_youtube == 1 ? $your_array[] = 'youtube' : 0;
            $google = $coupon->is_google == 1 ? $your_array[] = 'google_review' : 0;

            $text = null;
            $is_valid = true;
            foreach ($your_array as $item) {
                if (!in_array($item, $my_array)) {
                    $is_valid = false;
                    $text = $item;
                    break;
                }
            }

            return response(['is_valid' => $is_valid, 'missing' => $text, 'is_register' => $is_register]);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function sendNotificationFcm(Request $request)
    {
        try {
            $user_email = $request->input('email');
            $data = $request->input('data');
            $notification = $request->input('notification');

            $user_email_1 = $data['user_email_1'] ?? '';
            $user_email_2 = $data['user_email_2'] ?? '';

            $user_1 = User::where('email', $user_email_1)->first();
            $user_2 = User::where('email', $user_email_2)->first();

            if (!$user_1 || !$user_2) {
                $link = "";
            } else {
                $link = route('agora.joinMeeting', ['user_id_1' => $user_1->id, 'user_id_2' => $user_2->id]);
            }

            $data['link'] = $link;

            $user = User::where('email', $user_email)->first();

            if (!$user || $user->status == UserStatus::DELETED) {
                return response($this->returnMessage('User not found'), 404);
            }

            $token = $user->token_firebase;
            if (!$token) {
                return response($this->returnMessage('Token not found'), 404);
            }

            $response = $this->sendNotification($token, $data, $notification);
            $data = $response->getContents();
            return response($data);
        } catch (\Exception $exception) {
            return response($this->returnMessage($exception->getMessage()), 400);
        }
    }

    public function sendNotification($device_token, $data, $notification)
    {
        $client = new Client();
        $YOUR_SERVER_KEY = Constants::GG_KEY;

        $response = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . $YOUR_SERVER_KEY,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $device_token,
                'data' => $data,
                'notification' => $notification,
                'web' => [
                    'notification' => $notification,
                ],
            ],
        ]);

        return $response->getBody();
    }

    public function sendNotificationWeb(Request $request)
    {
        try {
            $client = new Client();
            $YOUR_SERVER_KEY = Constants::GG_KEY;
            $device_token = $request->input('token');

            $data = array(
                'message' => array(
                    'token' => $device_token,
                    'notification' => array(
                        'title' => 'FCM Message',
                        'body' => 'This is a message from FCM'
                    ),
                    'webpush' => array(
                        'headers' => array(
                            'Urgency' => 'high'
                        ),
                        'notification' => array(
                            'body' => 'This is a message from FCM to web',
                            'requireInteraction' => true,
                            'badge' => '/badge-icon.png'
                        )
                    )
                ));
            $jsonData = json_encode($data);

            $response = $client->post('https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $YOUR_SERVER_KEY,
                    'Content-Type' => 'application/json',
                ],
                'body' => $jsonData,
            ]);
            return $response;
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    
    //API register new user from zalo
    public function zaloRegister(Request $request)
    {
        try {
            $email = $request->input('email');
            $username = $request->input('username');
            $password = $request->input('password');
            $passwordConfirm = $request->input('passwordConfirm');
            $member = $request->input('member');
            $medical_history = $request->input('medical_history');
            $type = $request->input('type');
            $openDate = $request->input('open_date');
            $closeDate = $request->input('close_date');
            $province_id = $request->input('province_id');
            $district_id = $request->input('district_id');
            $commune_id = $request->input('commune_id');
            $address_detail = $request->input('address');
            $time_work = $request->input('time_work');
            $provider_name = $request->input('provider_name') ?? "";
            $provider_id = $request->input('provider_id') ?? "";

            $address = $request->input('combined_address');
            $representative = $request->input('representative');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $experienceHospital = $request->input('experienceHospital');
            if ($province_id && $district_id && $commune_id) {
                $province = explode('-', $province_id);
                $district = explode('-', $district_id);
                $commune = explode('-', $commune_id);
            }

            $currentDate = Carbon::now();


            $user = new User();

            $checkPending = false;

            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                throw new \Exception('Invalid email');
            }

            $oldUser = User::where('email', $email)->first();
            if ($oldUser) {
                throw new \Exception('Email already existed');
            }

            $oldUser = User::where('username', $username)->first();
            if ($oldUser) {
                throw new \Exception('Username already existed');
            }

            if ($password != $passwordConfirm) {
                throw new \Exception('Password or Password Confirm incorrect!');
            }

            if (strlen($password) < 5) {
                throw new \Exception('Password is invalid!');
            }

            if ($type == \App\Enums\Role::BUSINESS) {
                /* kiểm tra xem fileupload có tồn tại không, nếu không thì thông báo lỗi */
                if (!$request->hasFile('fileupload')) {
                    throw new \Exception('Cần up file giấy phép kinh doanh');
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
                    throw new \Exception('Cần up file giấy phép hành nghề');
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
                $contact_phone = $request->input('contact_phone');
                $experience = $request->input('experience');
                $hospital = $request->input('hospital');
                $specialized_services = $request->input('specialized_services');
                $services_info = $request->input('services_info');
                $user->name = $name_doctor;
                $user->identifier = $request->input('identifier');
                $user->phone = $contact_phone;
                $user->year_of_experience = $experience ?? '';
                $user->hospital = $hospital ?? '';
                $user->specialty = $specialized_services ?? '';
                $user->service = $services_info ?? '';
                $user->prescription = $request->has('prescription') ? (int)$request->input('prescription') : 0;
                $user->free = $request->has('free') ? (int)$request->input('free') : 0;
            } else {
                $user->name = '';
                $user->phone = '';
            }

            if ($member == \App\Enums\Role::NORMAL_PEOPLE || $member == \App\Enums\Role::PAITENTS) {
                $user->medical_history = $medical_history;
            }

            $user->last_name = '';
            $user->password = $passwordHash;
            $user->username = $username;
            $user->address_code = '';
            $user->type = $type;
            $user->member = $member;
            $user->provider_id = $provider_id;
            $user->provider_name = $provider_name;
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
                (new MainController())->createRoleUser($member, $username);

                if ($user->type == \App\Enums\Role::MEDICAL) {
                    return response()->json($user, 200);
                }
                if ($user->type == \App\Enums\Role::BUSINESS) {

                    $openDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $openDate);
                    $closeDateTime = Carbon::createFromFormat('Y-m-d H:i', $currentDate->format('Y-m-d') . ' ' . $closeDate);
                    $formattedOpenDateTime = $openDateTime->format('Y-m-d\TH:i');
                    $formattedCloseDateTime = $closeDateTime->format('Y-m-d\TH:i');

                    $hospital = new Clinic();
                    $hospital->address_detail = $address_detail;
                    $hospital->address = ',' . $province[0] . ',' . $district[0] . ',' . $commune[0];

                    $hospital->name = $representative;
                    $hospital->latitude = $latitude;
                    $hospital->longitude = $longitude;
                    $hospital->open_date = $formattedOpenDateTime ?? '';
                    $hospital->close_date = $formattedCloseDateTime ?? '';
                    $hospital->experience = $experienceHospital;
                    $hospital->gallery = $img ?? '';
                    $hospital->user_id = $user->id;
                    $hospital->time_work = $time_work;
                    $hospital->status = ClinicStatus::ACTIVE;
                    $hospital->type = $user->member;
                    $hospital->save();

                    $newUser = User::find($user->id);
                    $newUser->province_id = $province[0];
                    $newUser->district_id = $district[0];
                    $newUser->commune_id = $commune[0];
                    $newUser->address_code = $province[2];
                    $newUser->detail_address = $address_detail;
                    $newUser->year_of_experience = $experienceHospital;
                    $newUser->bac_si_dai_dien = $representative;
                    $newUser->name = $representative;
                    $newUser->save();

                    return response()->json($newUser, 200);
                }

                return response()->json($user, 200);
            }
            return response()->json('Something went wrong', 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()], 404);
        }
    }
}
