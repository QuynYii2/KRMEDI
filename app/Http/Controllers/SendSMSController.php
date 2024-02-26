<?php

namespace App\Http\Controllers;

use App\Models\SendSMS;
use Illuminate\Http\Request;

class SendSMSController extends Controller
{
    //site, loginName, password, sendServiceCode, brandName, unicode, url
    private $site;
    private $loginName;
    private $password;
    private $sendServiceCode;
    private $brandName;
    private $unicode;

    public function __construct()
    {
        $this->site = 'ILVIETNAM';
        $this->loginName = 'admin';
        $this->password = 'ILVIETNAM@1';
        $this->sendServiceCode = '11';
        $this->brandName = 'IL VIETNAM';
        $this->unicode = '0';
    }

    public function sendSMS($user_id, $to, $content)
    {
        $SmsId = random_int(100000, 999999) . "-" . time();
        $url = "https://api.s247.vn:8443/api/sms?site=" . $this->site . "&LoginName=" . $this->loginName
            . "&Password=" . $this->password . "&SendServiceCode=" . $this->sendServiceCode . "&BrandName=" . $this->brandName
            . "&mobile=" . $to . "&Message=" . $content . "&SmsId=" . $SmsId ."&Unicode=" . $this->unicode;

        // call url by HTTP:get method
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody(), true);
        if ($response['code'] == 1) {
            $this->WriteLogSMS($user_id, $to, $content);

            return true;
        } else {
            return false;
        }
    }

    private function WriteLogSMS($user_id, $to, $content)
    {
        $sendSMS = new SendSMS();

        $sendSMS->user_id_receiver = $user_id;
        $sendSMS->contact_info_user_receiver = $to;
        $sendSMS->content = $content;
        $sendSMS->save();
    }


}
