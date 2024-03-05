<?php

namespace App\Http\Controllers\connect;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ConnectCallVideo;
use App\Models\QueueDownloadChatVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class CallVideoController extends Controller
{
    public $METERED_DOMAIN;
    public $METERED_SECRET_KEY;

    public function __construct()
    {
        $this->METERED_DOMAIN = env('METERED_DOMAIN', 'krmedic.metered.live');
        $this->METERED_SECRET_KEY = env('METERED_SECRET_KEY', 'C5AjSOjZ-PaBArxWNQG8nSKp3eiWcsqltszk6Gvq6hnscIke');
    }

    /**
     * Display a listing of the resource.
     */

    public function index3()
    {
        return view('admin.connect.video.index-materu');
    }

    public function createMeeting(Request $request)
    {

        // Contain the logic to create a new meeting


        $data['from'] = Auth::user()->name;
        $data['to'] = $request->input('user_id_2');

        Cache::put('user_id_1', $request->input('user_id_1'));
        Cache::put('user_id_2', $request->input('user_id_2'));


        $connect = ConnectCallVideo::where('user_id_1', Auth::user()->id)->where('user_id_2', $data['to'])->first();

        if ($connect) {
            $roomName = $connect->room_name;
        } else {
            $response = Http::post("https://{$this->METERED_DOMAIN}/api/v1/room?secretKey={$this->METERED_SECRET_KEY}",
                [
                    'autoJoin' => true,
                    'enableComposition' => true,
                    'recordComposition' => true,
                ]);

            $roomName = $response->json("roomName");
        }

        $data['content'] = route('joinMeeting', ['meetingId' => $roomName]);

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $queueDownload = new QueueDownloadChatVideo();
        $queueDownload->user_id_1 = Cache::get('user_id_1');
        $queueDownload->user_id_2 = Cache::get('user_id_2');
        $queueDownload->room_name = $roomName;
        $queueDownload->status = false;
        $queueDownload->save();

        Cache::delete('user_id_1');
        Cache::delete('user_id_2');

        $PUSHER_APP_KEY = env('PUSHER_APP_KEY', '3ac4f810445d089829e8');
        $PUSHER_APP_SECRET = env('PUSHER_APP_SECRET', 'c6cafb046a45494f80b2');
        $PUSHER_APP_ID = env('PUSHER_APP_ID', '1714303');

        $PUSHER_APP_KEY = '3ac4f810445d089829e8';
        $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
        $PUSHER_APP_ID = '1714303';

        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);

        $pusher->trigger('send-message', 'send-message', $data);

        if ($connect) {
            return redirect(route('joinMeeting', ['meetingId' => $roomName])); // We will update this soon
        } else {
            $connect = new ConnectCallVideo();
            $connect->room_name = $roomName;

//            user_id_1 là người gọi
//            user_id_2 là người nhận/bác sĩ đươc gọi

            $connect->user_id_1 = $request->input('user_id_1');
            $connect->user_id_2 = $request->input('user_id_2');

            $connect->save();
            return redirect(route('joinMeeting', ['meetingId' => $roomName])); // We will update this soon.
        }
    }

    public function validateMeeting(Request $request)
    {

        $meetingId = $request->input('meetingId');

        // Contains logic to validate existing meeting
        $response = Http::get("https://{$this->METERED_DOMAIN}/api/v1/room/{$meetingId}?secretKey={$this->METERED_SECRET_KEY}");

        $roomName = $response->json("roomName");

        if ($response->status() === 200) {
            return redirect(route('joinMeeting', ['meetingId' => $roomName])); // We will update this soon
        } else {
            return redirect("/?error=Invalid Meeting ID");
        }
    }

    public function changeStatusQueueDownloadRecord($roomName)
    {
        $queueDownload = QueueDownloadChatVideo::where('room_name', $roomName)->first();

        if ($queueDownload) {
            $queueDownload->status = true;
            $queueDownload->save();
        }
    }

    public function handleDownloadRecordByRoomName()
    {
        $queueDownloads = QueueDownloadChatVideo::where('status', true)->get();

        if (count($queueDownloads) == 0) {
            return;
        }

        foreach ($queueDownloads as $queueDownload) {
            $recordIds = $this->getRecordIdByRoomName($queueDownload->room_name);

            foreach ($recordIds['data'] as $recordId) {
                $response = $this->downloadRecordByRoomName($recordId['_id'], $queueDownload);
            }
        }
    }

    private function getRecordIdByRoomName($roomName)
    {
        // Contains logic to validate existing meeting
        $response = Http::get("https://$this->METERED_DOMAIN/api/v1/recordings/room/$roomName?secretKey=$this->METERED_SECRET_KEY");

        return $response->json();
    }

    private function downloadRecordByRoomName($recordingId, $queueDownload)
    {

        // Contains logic to validate existing meeting
        $downloadUrl = Http::get("https://$this->METERED_DOMAIN/api/v1/recording/$recordingId/download?secretKey=$this->METERED_SECRET_KEY");

        $url = $downloadUrl['url'];

        $timeout = 21600; // time out 6h

        $response = Http::timeout($timeout)->get($url);

        if ($response->successful()) {
            $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));

            $fileName = $pathInfo['basename'];

            $pathFile = 'public/connect/video/'.$fileName;

            Storage::put($pathFile, $response->getBody()->getContents());

            $chat = new Chat();

//            user_id_1 là người gọi
//            user_id_2 là người nhận/bác sĩ đươc gọi

            $chat->from_user_id = $queueDownload->user_id_1;
            $chat->to_user_id = $queueDownload->user_id_2;
            $chat->chat_message = "File VIDEO CALL";
            $chat->files = $pathFile;

            $chat->save();

            $this->deleteByRecordId($recordingId, $queueDownload);

            // Optionally, you can return the local path or URL of the downloaded file
            return $fileName;
        } else {
            // Handle error
            return null;
        }
    }

    private function deleteByRecordId($recordingId, $queueDownload)
    {
        // Contains logic to validate existing meeting
        $response = Http::delete("https://$this->METERED_DOMAIN/api/v1/recording/$recordingId?secretKey=$this->METERED_SECRET_KEY");
        $queueDownload->delete();
    }


}
