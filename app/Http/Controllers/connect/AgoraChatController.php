<?php

namespace App\Http\Controllers\connect;

use App\Http\Controllers\Controller;
use App\Http\Controllers\restapi\MainApi;
use App\Models\AgoraChat;
use App\Models\Chat;
use App\Models\User;
use App\Services\GoogleCloudStorageService;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Pusher\Pusher;

class AgoraChatController extends Controller
{
    function index()
    {
        return redirect(env('CALL_APP_URL '));
        // return view('video-call.index');
    }
    private function acquireResource($channelName, $uid)
    {
        $appId = '76c76eecc0f44cff943b58ac64e2f372';
        $url = "https://api.agora.io/v1/apps/{$appId}/cloud_recording/acquire";
        $body = [
            'cname' => $channelName,
            'uid' => (string) $uid,
            'clientRequest' => [
                'resourceExpiredHour' => 24,
                "scene" => 0,
            ],
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("1d9f559f0e2346a8849ba2c2ef35a860:6568e86b523343dcb64797bb8469b58a"),
            'Content-Type' => 'application/json'
        ])->post($url, ($body));

        if ($response->successful()) {
            return $response->json()['resourceId'];
        } else {
            \Log::error("Agora API call failed", [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);
            throw new \Exception("Failed to acquire resource: " . $response->body());
        }
    }

    /**
     * Start recording with acquired resource ID
     */
    private function startRecording($channelName, $uid, $resourceId, $token)
    {
        $appId = '76c76eecc0f44cff943b58ac64e2f372';

        $url = "https://api.agora.io/v1/apps/{$appId}/cloud_recording/resourceid/{$resourceId}/mode/mix/start";

        $startTime = date('Ymd_His');
        $fileNamePrefix = "{$channelName}_{$startTime}/";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("1d9f559f0e2346a8849ba2c2ef35a860:6568e86b523343dcb64797bb8469b58a"),
            'Content-Type' => 'application/json'
        ])->post($url, [
            'cname' => $channelName,
            'uid' => (string) $uid,
            'clientRequest' => [
                "token" => $token,
                "recordingConfig" => [
                    "channelType"=> 0,
                    "streamTypes" => 2,
                    "audioProfile" => 1,
                    "videoStreamType" => 0,
                    "maxIdleTime" => 15,
                    "transcodingConfig" => [
                        "width" => 1280,
                        "height" => 720,
                        "fps" => 30,
                        "bitrate" => 900,
                        "maxResolutionUid" => "1",
                        "mixedVideoLayout" => 1,
                    ]
                ],
                "recordingFileConfig" => [
                    "avFileType" => ["hls"]
                ],
                'storageConfig' => [
                    'vendor'=> 1,
                    'region'=> 9,
                    'bucket'=> "video-storage-krmedi",
                    'accessKey'=> env('AWS_ACCESS_KEY_ID'),
                    'secretKey'=> env('AWS_SECRET_ACCESS_KEY'),
                ],
                'fileNamePrefix' => [$fileNamePrefix]
            ]
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            return [
                'sid' => $responseData['sid'],
                'uid' => $responseData['uid'],
            ];
        } else {
            throw new \Exception("Failed to start recording: " . $response->body());
        }
    }

//    private function updateLayout($channelName, $uid, $resourceId, $sid)
//    {
//        $appId = '76c76eecc0f44cff943b58ac64e2f372';
//
//        $url = "https://api.agora.io/v1/apps/{$appId}/cloud_recording/resourceid/{$resourceId}/sid/{$sid}/mode/mix/updateLayout";
//
//        $response = Http::withHeaders([
//            'Authorization' => 'Basic ' . base64_encode("1d9f559f0e2346a8849ba2c2ef35a860:6568e86b523343dcb64797bb8469b58a"),
//            'Content-Type' => 'application/json'
//        ])->post($url, [
//            'cname' => $channelName,
//            'uid' => (string) $uid,
//            'clientRequest' => [
//                'mixedVideoLayout' => 3,
//                'layoutConfig' => [
//                    [
//                        'uid' => '1',
//                        'x_axis' => 0.1,
//                        'y_axis' => 0.1,
//                        'width' => 0.1,
//                        'height' => 0.1,
//                        'alpha' => 1.0,
//                        'render_mode' => 1
//                    ],
//                    [
//                        'uid' => '2',
//                        'x_axis' => 0.2,
//                        'y_axis' => 0.2,
//                        'width' => 0.1,
//                        'height' => 0.1,
//                        'alpha' => 1.0,
//                        'render_mode' => 1
//                    ]
//                ]
//            ]
//        ]);
//        if ($response->successful()) {
//            $responseData = $response->json();
//        } else {
//            throw new \Exception("Failed to update layout recording: " . $response->body());
//        }
//    }

    private function queryRecord($resourceId, $sid)
    {
        $appId = '76c76eecc0f44cff943b58ac64e2f372';

        $url = "https://api.agora.io/v1/apps/{$appId}/cloud_recording/resourceid/{$resourceId}/sid/{$sid}/mode/mix/query";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("1d9f559f0e2346a8849ba2c2ef35a860:6568e86b523343dcb64797bb8469b58a"),
            'Content-Type' => 'application/json'
        ])->get($url);
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            throw new \Exception("Failed to query: " . $response->body());
        }
    }
    function handleCallVideo(Request $request)
    {
        try {
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

            // Check token have last updated more than 10mins then refresh token
            $currentDateTime = Carbon::now();

            if (Carbon::parse($agora_chat->updated_at)->diffInMinutes($currentDateTime) > 10) {
                //Refresh token
                $this->handleRefreshToken($request);
            }

            $token      = $agora_chat->token ?? null;
            $channel    = $agora_chat->channel ?? null;
            $fromUser     = $agora_chat->user_id_1 ?? 0;
            $toUser     = $agora_chat->user_id_2 ?? 0;

            $accessTokenFromUser = User::find($fromUser)->token ?? '';
            $accessTokenToUser   = User::find($toUser)->token ?? '';

            //call acquire and start record video here:
            $resourceId = $this->acquireResource($channel, $fromUser);
                try {
                    $startResponse = $this->startRecording($channel, $fromUser, $resourceId, $token);
                } catch (\Exception $e) {
                    toast('Cuộc gọi đang gián đoạn, vui lòng thử lại sau 15 giây!', 'error', 'top-left');
                    return back();
                }
    //        $updateLayout = $this->updateLayout($channel, $fromUser, $resourceId, $startResponse['sid']);

                try {
                    $queryRecord = $this->queryRecord($resourceId, $startResponse['sid']);
                } catch (\Exception $e) {
                    toast('Cuộc gọi đang gián đoạn, vui lòng thử lại sau 15 giây!', 'error', 'top-left');
                    return back();
                }
            //Params của user tạo cuộc gọi
            $callFromParams = [
                'token'         => $token,
                'channel'       => $channel,
                'user_id'       => $fromUser,
                'guest_id'      => $toUser,
                'accessToken'   => $accessTokenFromUser,
                'resourceId'=> $resourceId,
                'sid' => $startResponse['sid'],
                'uid' => $startResponse['uid'],
            ];

            //Params của user nhận cuộc gọi
            $callToParams = [
                'token'         => $token,
                'channel'       => $channel,
                'user_id'       => $toUser,
                'guest_id'      => $fromUser,
                'accessToken'   => $accessTokenToUser,
                'resourceId'=> $resourceId,
                'sid' => $startResponse['sid'],
                'uid' => $startResponse['uid'],
            ];

            $data['content'] = env('CALL_APP_URL') . '?' . http_build_query($callToParams);

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

            //DATA WEB CALL WEB
            $pusher->trigger('send-message', 'send-message', $data);

            // gui notification den user_id_1
            $userReceiveCall = User::find($user_id_2);
            $userCall = User::find($user_id_1);

            $this->sendNotificationToAppByFireBase($userReceiveCall->email, $userCall);

            return redirect()->to(env('CALL_APP_URL') . '?' . http_build_query($callFromParams));
        } catch (\Exception $e) {
            toast('Cuộc gọi đang gián đoạn, vui lòng thử lại sau 15 giây!', 'error', 'top-left');
            return back();
        }
    }

    public function downloadRecord(Request $request)
    {
        $channelName = $request->input('channelName');
        $sID = $request->input('sID');
        $bucketName = 'video-storage-krmedi';
        $searchString = $sID;
        $dateCall = $channelName . '_' . date('Ymd_His');
        $saveDir = storage_path('app/public/video-record/' . $dateCall . '/');

        // Ensure the save directory exists
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }

        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ap-southeast-2',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        try {
            // List objects in the bucket
            $result = $s3Client->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => '',
            ]);

            $objects = $result['Contents'];
            $filteredObjects = array_filter($objects, function ($object) use ($searchString) {
                return strpos($object['Key'], $searchString) !== false;
            });

            if (empty($filteredObjects)) {
                return response()->json(['message' => "No objects found with the search string: {$searchString}"], 404);
            }

            $m3u8Path = null;
            foreach ($filteredObjects as $object) {
                $objectKey = $object['Key'];
                $saveAsPath = $saveDir . basename($objectKey);

                $s3Client->getObject([
                    'Bucket' => $bucketName,
                    'Key'    => $objectKey,
                    'SaveAs' => $saveAsPath,
                ]);

                if (str_ends_with($objectKey, '.m3u8')) {
                    $m3u8Path = 'video-record/' . $dateCall . '/' . basename($objectKey);
                }
            }

            $chat = new Chat;
            $chat->from_user_id = $request->input('user_id');
            $chat->to_user_id = $request->input('guest_id');
            $chat->chat_message = "Cuộc gọi Video - " . now()->format('H:i d/m/Y');
            $chat->files = $m3u8Path;
            $chat->message_status = 'UNSEEN';
            $chat->created_at = now();
            $chat->updated_at = now();
            $chat->type = null;
            $chat->uuid_session = null;
            $chat->save();

            return response()->json(['message' => "Files downloaded successfully to: {$saveDir}"], 200);
        } catch (\Aws\Exception\AwsException $e) {
            return response()->json(['error' => "Error downloading files: " . $e->getMessage()], 500);
        }
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

        //OLD
//        $appid = '0b47427ee7334417a90ff22c4e537b08';
        //NEW
        $appid = '76c76eecc0f44cff943b58ac64e2f372';

        $array_email = [User::getEmailByID($user_id_1), User::getEmailByID($user_id_2)];

        // sort array email
        sort($array_email);

        // Check token have last updated more than 10mins then refresh token
        $currentDateTime = Carbon::now();

        if ($oldAgora && Carbon::parse($oldAgora->updated_at)->diffInMinutes($currentDateTime) < 10) {
            //Token is new < 10 mins
            $token = $oldAgora->token;
            $channel = $oldAgora->channel;
        } else {
            $channel = implode('_', $array_email);
            $uuid = rand(0, 10000);

            $token = $this->genNewTokenByChanelName($channel, $user_id_1, $user_id_2);
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

    function genNewTokenByChanelName($chanelName, $user_id_1, $user_id_2)
    {
        //OLD
//        $appIdAgora = '0b47427ee7334417a90ff22c4e537b08';
//        $appCertificateAgora = 'd35960a9bfb146ceb33a3a40c0b9ab3b';

        //NEW
        $appIdAgora = '76c76eecc0f44cff943b58ac64e2f372';
        $appCertificateAgora = 'dbe58cff64734d3ba642784249babfdd';

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
                'uid' => '',
                'role' => 'publisher',
                'expire' => 3600,
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
            'sound' => 'custom_sound.wav',
            "android_channel_id" => "video_call_channel_id",
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

        $token_1 = $agora_chat_1->token ?? '';
        $token_2 = $agora_chat_2->token ?? '';

        if ($token_1 == $token_2 || !$token_1 || !$token_2) {
            $token = $this->genNewTokenByChanelName($agora_chat_1->channel, $user_id_1, $user_id_2);
            if ($agora_chat_1) {
                $agora_chat_1->token = $token;
                $agora_chat_1->save();
            }
            if ($agora_chat_2) {
                $agora_chat_2->token = $token;
                $agora_chat_2->save();
            }
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

        // Check token have last updated more than 10mins then refresh token
        $currentDateTime = Carbon::now();
        if (Carbon::parse($agora_chat->updated_at)->diffInMinutes($currentDateTime) > 10) {
            //Refresh token
            $this->handleRefreshToken($request);
        }

        $token      = $agora_chat->token ?? null;
        $channel    = $agora_chat->channel ?? null;
        $fromUser   = $agora_chat->user_id_1 ?? 0;
        $toUser     = $agora_chat->user_id_2 ?? 0;

        $accessTokenFromUser = User::find($fromUser)->token ?? '';
        $accessTokenToUser   = User::find($toUser)->token ?? '';

        //Params của user tạo cuộc gọi
        $callFromParams = [
            'token'         => $token,
            'channel'       => $channel,
            'user_id'       => $fromUser,
            'guest_id'      => $toUser,
            'accessToken'   => $accessTokenFromUser
            // 'to_user'       => $toUser,
        ];

        //Params của user nhận cuộc gọi
        $callToParams = [
            'token'         => $token,
            'channel'       => $channel,
            'from_user'     => $fromUser,
            'user_id'       => $toUser,
            'guest_id'      => $fromUser,
            'accessToken'   => $accessTokenToUser
        ];

        return redirect(env('CALL_APP_URL') . '?' . http_build_query($callToParams));

        // return view('video-call.index', compact('agora_chat', 'patient'));
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
