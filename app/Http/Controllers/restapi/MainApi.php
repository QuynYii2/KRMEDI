<?php

namespace App\Http\Controllers\restapi;

use App\Enums\Constants;
use App\Enums\CouponStatus;
use App\Services\FcmService;
use App\Enums\SocialUserStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TranslateController;
use App\Models\Clinic;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\SocialUser;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainApi extends Controller
{

    private FcmService $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

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
            $channel = $request->input('channel');
            $user = User::where('email', $user_email)->first();
            $platform = $user->devices_name;

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

            //            $this->sendVideoCallNotification($token, $data, $platform, $channel);
            $data = $this->sendNotification($token, $data, $notification, $channel)->getContents();
            return response($data);
        } catch (\Exception $exception) {
            Log::error("Unable to call MainApi::sendNotificationFcm", ['exception' => $exception]);
            return response($this->returnMessage($exception->getMessage()), 400);
        }
    }

    public function sendNotification($device_token, $data, $notification, ?string $channel)
    {
        $payload = [
            'token' => $device_token,
            'data' => array_reduce(array_keys($data), function ($result, $key) use ($data) {
                $result[$key] = is_array($data[$key]) ? json_encode($data[$key]) : (string) $data[$key];
                return $result;
            }, []),
            'notification' => $notification,
            'webpush' => [
                'notification' => $notification,
            ],
        ];
        if ($channel !== null) {
            $payload['android'] = [
                'notification' => [
                    'channel_id' => $channel,
                ]
            ];
        }

        return $this->fcmService->request($payload);
    }

    public function sendVideoCallNotification($firebaseToken, $data, $platform, ?string $channel)
    {
        try {
            $client = new Client();
            $YOUR_SERVER_KEY = Constants::GG_KEY;

            $notificationPayload = [
                'title' => 'Bạn có 1 cuộc gọi mới',
                'body' => 'Bạn có thông báo mới',
            ];

            $androidPayload = [
                'notification' => [
                    'icon' => 'ic_launcher',
                    'channel_id' => 'video_call_channel_id',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'image' => 'https://example.com/image.png',
                    'sound' => 'custom_sound.wav',
                    'color' => '#ff0000',
                ],
            ];

            $iosPayload = [
                'aps' => [
                    'sound' => 'custom_sound.wav',
                    'badge' => 1,
                ],
            ];

            $transformedData = array_reduce(array_keys($data), function ($result, $key) use ($data) {
                $result[$key] = is_array($data[$key]) ? json_encode($data[$key]) : (string) $data[$key];
                return $result;
            }, []);

            $payload = [
                'token' => $firebaseToken,
                'notification' => $notificationPayload,
                'data' => array_merge($transformedData, [
                    'channel_id' => 'video_call_channel_id',
                ]),
            ];

            // Add platform-specific fields
            if ($platform === 'ANDROID') {
                $payload['android'] = $androidPayload;
            } elseif ($platform === 'IOS') {
                $payload['apns'] = ['payload' => $iosPayload];
            }

            return $this->fcmService->request($payload);
        } catch (\Exception $e) {
            return response($this->returnMessage($e->getMessage()), 400);
        }
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
                )
            );
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

    //Booking created
    public function sendFcmNotification(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'clinic_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'clinic_title' => 'nullable|string',
                'user_title' => 'nullable|string',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $userId = $validatedData['user_id'];

            $bookingId = $validatedData['id'];

            $clinicId = $validatedData['clinic_id'];

            if (!isset($validatedData['clinic_title'])) {
                $clinicTitle =  'Lịch khám mới đã được đặt';
            } else {
                $clinicTitle =  $validatedData['clinic_title'];
            }

            if (!isset($validatedData['user_title'])) {
                $userTitle = 'Đặt lịch khám thành công';
            } else {
                $userTitle = $validatedData['user_title'];
            }

            $hospitalUser = Clinic::with('users')->find($clinicId);

            $hospitalToken = $hospitalUser->users->token_firebase ?? "";

            $hospitalNotification = Notification::create([
                'title' => $clinicTitle,
                'sender_id' => $userId,
                'follower' => $hospitalUser->users->id,
                'target_url' => route('api.backend.booking.edit', ['id' => $bookingId]),
                'description' => 'Kiểm tra lịch khám ngay!!',
                'booking_id' => $bookingId
            ]);

            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );

            $PUSHER_APP_KEY = '3ac4f810445d089829e8';
            $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
            $PUSHER_APP_ID = '1714303';

            $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

            $requestData = [
                'user_id' => $hospitalUser->users->id,
                'title' => 'Lịch khám mới đã được đặt , Vui lòng kiểm tra lịch khám ngay!!',
            ];

            $pusher->trigger('noti-events', 'noti-events', $requestData);

            if ($hospitalToken) {
                $response = $this->sendBookingNotification($hospitalToken, null, $hospitalNotification);
            }

            $userToken = User::find($userId)->token_firebase ?? "";

            $userNotification = Notification::create([
                'title' => $userTitle,
                'sender_id' => $hospitalUser->users->id,
                'follower' => $userId,
                'target_url' => route('booking.detail.by.user', ['id' => $bookingId]),
                'description' => 'Kiểm tra lịch khám ngay!!',
                'booking_id' => $bookingId
            ]);
            $requestData2 = [
                'user_id' => $userId,
                'title' => 'Đặt lịch khám thành công!!',
            ];

            $pusher->trigger('noti-events', 'noti-events', $requestData2);
            if ($userToken) {
                $response = $this->sendBookingNotification(null, $userToken, $userNotification);
            }


            $data = $response->getContents();
            return response($data);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    //Prescription reminder
    public function sendFcmNotificationOnPrescriptionReminder(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'cart_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'title' => 'required|string',
                'description' => 'nullable|string'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $userId = $validatedData['user_id'];

            $cartId = $validatedData['cart_id'];

            $title = $validatedData['title'];

            $description = $validatedData['description'] ?? "";

            $userToken = User::find($userId)->token_firebase ?? "";

            $userNotification = Notification::create([
                'title' => $title,
                'sender_id' => $userId,
                'follower' => $userId,
                'target_url' => '#',
                'description' => $description,
                'cart_id' => $cartId
            ]);

            if ($userToken) {
                $response = $this->sendPrescriptionReminderNotification($userToken, $userNotification);
            }


            $data = $response->getContents();
            return response($data);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }

    private function sendPrescriptionReminderNotification($userToken = null, $notification)
    {
        $client = new Client();
        $YOUR_SERVER_KEY = Constants::GG_KEY;

        $data = [];

        if ($userToken) {
            $notificationWithSender = Notification::with('senders')->find($notification->id);

            $data = [
                'title' => $notificationWithSender->title ?? "",
                'sender' => $notificationWithSender->senders->avt ?? "",
                'url' => $notificationWithSender->target_url ?? "#",
                'description' => $notificationWithSender->description ?? "",
                'id' => (string) $notificationWithSender->id,
                'cart_id' => (string) $notificationWithSender->cart_id,
            ];

            return $this->fcmService->request([
                'token' => $userToken,
                'data' => $data,
                'notification' => [
                    'title' => 'Bạn vừa nhận được 1 thông báo mới',
                    'body' => 'Cart',
                ],
                'webpush' => [
                    'notification' => [
                        'title' => 'Bạn vừa nhận được 1 thông báo mới',
                        'body' => 'Cart',
                    ],
                ],
            ]);
        }

        return null;
    }

    private function sendBookingNotification($hospitalToken = null, $userToken = null, $notification)
    {
        $client = new Client();
        $YOUR_SERVER_KEY = Constants::GG_KEY;

        $data = [];

        if ($hospitalToken) {
            $notificationWithSender = Notification::with('senders')->find($notification->id);

            $data = [
                'title' => $notificationWithSender->title ?? "",
                'sender' => $notificationWithSender->senders->avt ?? "",
                'url' => $notificationWithSender->target_url ?? "#",
                'description' => $notificationWithSender->description ?? "",
                'id' => (string) $notificationWithSender->id,
            ];

            return $this->fcmService->request([
                'token' => $hospitalToken,
                'data' => $data,
                'notification' => [
                    'title' => 'Bạn vừa nhận được 1 thông báo mới',
                    'body' => 'Booking',
                ],
                'webpush' => [
                    'notification' => [
                        'title' => 'Bạn vừa nhận được 1 thông báo mới',
                        'body' => 'Booking',
                    ],
                ],
            ]);
        }

        if ($userToken) {
            $notificationWithSender = Notification::with('senders')->find($notification->id);

            $data = [
                'title' => $notificationWithSender->title ?? "",
                'sender' => $notificationWithSender->senders->avt ?? "",
                'url' => $notificationWithSender->target_url ?? "#",
                'description' => $notificationWithSender->description ?? "",
                'id' => (string) $notificationWithSender->id,
            ];

            return $this->fcmService->request([
                'token' => $userToken,
                'data' => $data,
                'notification' => [
                    'title' => 'Bạn vừa nhận được 1 thông báo mới',
                    'body' => 'Booking',
                ],
                'webpush' => [
                    'notification' => [
                        'title' => 'Bạn vừa nhận được 1 thông báo mới',
                        'body' => 'Booking',
                    ],
                ],
            ]);
        }

        return null;
    }

    public function sendQuestionNotification($userToken = null, $notificationID)
    {
        $client = new Client();
        $YOUR_SERVER_KEY = Constants::GG_KEY;

        if ($userToken) {
            $notificationWithSender = Notification::with('senders')->find($notificationID);

            $data = [
                'title' => $notificationWithSender->title ?? "",
                'sender' => $notificationWithSender->senders->avt ?? "",
                'description' => $notificationWithSender->description ?? "",
                'id' => (string) $notificationWithSender->id,
            ];

            return $this->fcmService->request([
                'token' => $userToken,
                'data' => $data,
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['description'],
                ],
                'webpush' => [
                    'notification' => [
                        'title' => $data['title'],
                        'body' => $data['description'],
                    ],
                ],
            ]);
        }

        return $response->getBody();
    }
}
