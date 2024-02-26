<?php

namespace App\Http\Controllers\connect;

use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Models\AgoraChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Pusher\Pusher;

class AgoraChatController extends Controller
{
    function index()
    {
        return view('video-call.index');
    }

    function handleCallVideo(Request $request)
    {
        $user_id_1 = $request->input('user_id_1');
        $user_id_2 = $request->input('user_id_2');

        // find agorachat by user_id_1 =  user_id_1 or user_id_2 and user_id_2 = user_id_2 or user_id_1
        $agora_chat = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->first();


        if (!$agora_chat) {
            $agora_chat = $this->createMeeting($request);
        }

        $data['content'] = route('agora.joinMeeting', ['user_id_1' => $user_id_2, 'user_id_2' => $user_id_1]);
        $data['user_id_1'] = $user_id_2;
        $data['user_id_2'] = $user_id_1;

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $PUSHER_APP_KEY = '3ac4f810445d089829e8';
        $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
        $PUSHER_APP_ID = '1714303';

        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

        $pusher->trigger('send-message', 'send-message', $data);

        // gui notification den user_id_1
        $userReciveCall = User::find($user_id_2);
        $userCall = User::find($user_id_1);

        $this->sendNotificationToAppByFireBase($userReciveCall->email, $userCall);

        return view('video-call.index', compact('agora_chat'));

    }

    function createMeeting(Request $request)
    {
        $user_id_1 = $request->input('user_id_1');
        $user_id_2 = $request->input('user_id_2');

        $oldAgora = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->orWhere([
            ['user_id_1', $user_id_2],
            ['user_id_2', $user_id_1],
        ])->first();


        $appid = '0b47427ee7334417a90ff22c4e537b08';

        $array_email = [User::getEmailByID($user_id_1), User::getEmailByID($user_id_2)];

        // sort array email
        sort($array_email);

        if ($oldAgora) {
            $token = $oldAgora->token;
            $channel = $oldAgora->channel;
        } else {
            $channel = implode('_', $array_email);
            $uuid = rand(0, 10000);

            $token = $this->genNewTokenByChanelName($channel, $user_id_1);
        }

        $agora_chat = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->first();

        if (!$agora_chat) {
            $agora_chat = new AgoraChat();
            $agora_chat->user_id_1 = $user_id_1;
            $agora_chat->user_id_2 = $user_id_2;
        }

        $agora_chat->appid = $appid;
        $agora_chat->uid = $user_id_1;
        $agora_chat->token = $token;
        $agora_chat->channel = $channel;

        $agora_chat->save();

        return $agora_chat;
    }

    function genNewTokenByChanelName($chanelName, $user_id_1)
    {
        $appIdAgora = '0b47427ee7334417a90ff22c4e537b08';
        $appCertificateAgora = 'd35960a9bfb146ceb33a3a40c0b9ab3b';

        $response = Http::withHeaders([
            'authority' => 'agora-token-generator-demo.vercel.app',
            'accept' => '*/*',
            'accept-language' => 'vi,en-US;q=0.9,en;q=0.8,vi-VN;q=0.7,ko;q=0.6,ja;q=0.5',
            'content-type' => 'application/json',
            'origin' => 'https://agora-token-generator-demo.vercel.app',
            'referer' => 'https://agora-token-generator-demo.vercel.app/',
            'sec-ch-ua' => '"Not_A Brand";v="8", "Chromium";v="120", "Google Chrome";v="120"',
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => '"Windows"',
            'sec-fetch-dest' => 'empty',
            'sec-fetch-mode' => 'cors',
            'sec-fetch-site' => 'same-origin',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ])
            ->post('https://agora-token-generator-demo.vercel.app/api/main?type=rtc', [
                'appId' => $appIdAgora,
                'certificate' => $appCertificateAgora,
                'channel' => $chanelName,
                'uid' => $user_id_1,
                'role' => 'publisher',
                'expire' => time() + 3600,
            ]);

        // Access response data
        $responseData = $response->json();
        return $responseData['rtcToken'];

    }

    function stripVN($str)
    {
        if (!$str) {
            return 'Default Name';
        }

        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        return $str;
    }

    function sendNotificationToAppByFireBase($email, $userCall)
    {
        $user_id_1 = $userCall->id;
        $user_id_2 = User::where('email', $email)->first()->id;
        $content = route('agora.joinMeeting', ['user_id_1' => $user_id_1, 'user_id_2' => $user_id_2]);

        $notification = [
            "title" => "Cuộc gọi đến",
            "body" => $userCall->name ?? "Không rõ",
            "android_channel_id" => "callkit_incoming_channel_id",
            'click_action' => $content,
        ];

        $uuid = rand(1000000000, 9999999999);

        // hash uuid to int
        $hashedValue = hash('sha256', $uuid);
        $hashUUID = hexdec($hashedValue);

        $data = [
            "uid" => $uuid, // cái này em gửi cho anh 1 hash của uuid v4
            "rtmUid" => $hashUUID, // cái này là cái uuid vừa gen ra ở bên trên
            "type" => "1", // 1 với video, 0 với voice
            "startTime" => now()->timestamp, // thời gian bắt đầu cuộc gọi

            "link" => '',
            'user_email_1' => '',
            'user_email_2' => '',

            // thông tin người gọi
            "requestUser" => [
                "image" => 'https://krmedi.vn/' . $userCall->avatar,
                "about" => "t",
                "name" => $userCall->name,
                "createdAt" => $userCall->created_at,
                "isOnline" => true,
                "id" => strval($userCall->id),
                "lastActive" => "",
                "email" => $userCall->email,
                "pushToken" => $hashUUID,
                "role" => "",
                "departmentId" => "",
            ],
            "actionType" => "", // nếu gọi bình thường thì không gửi lên, nếu là huỷ cuộc gọi hoặc kết thúc cuộc gọi mới gửi "END_REQUEST"
        ];

        $request = new Request();
        $request->merge(['email' => $email, 'notification' => $notification, 'data' => $data]);

        $mainAPi = new MainApi();

        $response = $mainAPi->sendNotificationFcm($request);
    }

    public function getInfoAgoraForApp(Request $request)
    {
        if ($request->has('email_1')) {
            $email_1 = $request->input('email_1');
            $user_1 = User::where('email', $email_1)->first()->id;

            $valuesToAdd = ['user_id_1' => $user_1];
            $request->merge($valuesToAdd);
        }

        if ($request->has('email_2')) {
            $email_2 = $request->input('email_2');
            $user_2 = User::where('email', $email_2)->first()->id;

            $valuesToAdd = ['user_id_2' => $user_2];
            $request->merge($valuesToAdd);
        }

        $agora_chat = $this->createMeeting($request);

        return response()->json($agora_chat);
    }

    function handleRefreshToken(Request $request)
    {
        $user_id_1 = $request->input('user_id_1');
        $user_id_2 = $request->input('user_id_2');

        $agora_chat_1 = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->first();

        $agora_chat_2 = AgoraChat::where([
            ['user_id_1', $user_id_2],
            ['user_id_2', $user_id_1],
        ])->first();

        $token_1 = $agora_chat_1->token;
        $token_2 = $agora_chat_2->token;

        if ($token_1 == $token_2) {
            $token = $this->genNewTokenByChanelName($agora_chat_1->channel, $user_id_1);
            $agora_chat_1->token = $token;
            $agora_chat_2->token = $token;
            $agora_chat_1->save();
            $agora_chat_2->save();
        }
    }

    function saveTokenByUserId(Request $request)
    {
        $user_id_1 = $request->input('user_id_1');
        $user_id_2 = $request->input('user_id_2');
        $token = $request->input('token');

        $agora_chat = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->first();

        $agora_chat->token = $token;
        $agora_chat->save();

        return $agora_chat;
    }

    function joinMeeting(Request $request)
    {
        $user_id_1 = $request->input('user_id_1');
        $user_id_2 = $request->input('user_id_2');

        $agora_chat = AgoraChat::where([
            ['user_id_1', $user_id_1],
            ['user_id_2', $user_id_2],
        ])->first();

        if (!$agora_chat) {
            $agora_chat = $this->createMeeting($request);
        }

        return view('video-call.index', compact('agora_chat'));

    }

    function getPushTokenByUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_email = $request->input('user_email');
        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = User::where('email', $user_email)->first();
        }

        if (!$user) {
            return response((new MainApi())->returnMessage('User not found'), 500);
        }

        $result = [
            'pushToken' => $user->token_firebase ?? '',
            'id' => $user->id ?? '',
            'email' => $user->email ?? '',
        ];

        return response()->json($result);
    }

}
