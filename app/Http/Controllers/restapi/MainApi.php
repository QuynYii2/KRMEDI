<?php

namespace App\Http\Controllers\restapi;

use App\Enums\Constants;
use App\Enums\CouponStatus;
use App\Enums\SocialUserStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\Coupon;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\SocialUser;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
}
