<?php

namespace App\Http\Controllers;

use App\Models\ZaloOaModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function check_mobile ()
    {
        $agent = new \Jenssegers\Agent\Agent;

        $result = $agent->isPhone();
        return $result;
    }

    public function getTokenZaloZns()
    {
        $token = ZaloOaModel::first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://oauth.zaloapp.com/v4/oa/access_token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'refresh_token=' . $token->refresh_token . '&app_id=' . $token->app_id . '&grant_type=refresh_token',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'secret_key: ' . $token->secret_key . ''
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        if (isset($data->refresh_token)) {
            $token->refresh_token = $data->refresh_token;
            $token->access_token = $data->access_token;
            $token->save();
            $dataReturn['status'] = true;
            $dataReturn['access_token'] = $data->access_token;
        } else {
            $dataReturn['status'] = false;
        }
        return $dataReturn;
    }

//    public function sendZaloMessageBooking($booking,$user,$hospital,$specialist)
//    {
//        $data = $this->getTokenZaloZns();
//        if ($data['status'] == false) {
//            return back()->with(['error' => 'Refresh Token đã hết hạn']);
//        }
//        $phoneNumber = '84' . substr($user->phone, 1);
//        $curl = curl_init();
//
//        $postData = array(
//            "phone" => $phoneNumber,
//            "template_id" => "334477",
//            "template_data" => array(
//                "name" => $user->name,
//                "hospital" => $hospital->name,
//                "specialist"=> $specialist,
//                "custom_url"=>'home%2Fbooking-detail%2F'.$hospital->id,
//                "date" => \Carbon\Carbon::parse($booking->check_in)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')
//            ),
//            "tracking_id" => 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'
//        );
//
//        $headers = array(
//            'access_token: '.$data['access_token'],
//            'Content-Type: application/json'
//        );
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://business.openapi.zalo.me/message/template',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => json_encode($postData),
//            CURLOPT_HTTPHEADER => $headers,
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
//
//        return $response;
//    }
//
//    public function sendZaloMessageBookingComplete($booking,$user,$hospital,$specialist,$doctor)
//    {
//        $data = $this->getTokenZaloZns();
//        if ($data['status'] == false) {
//            return back()->with(['error' => 'Refresh Token đã hết hạn']);
//        }
//        $phoneNumber = '84' . substr($user->phone, 1);
//        $curl = curl_init();
//
//        $postData = array(
//            "phone" => $phoneNumber,
//            "template_id" => "334492",
//            "template_data" => array(
//                "name" => $user->name,
//                "hospital" => $hospital->name,
//                "specialist"=> $specialist,
//                "custom_url"=>'home%2Fbooking-detail%2F'.$hospital->id,
//                "doctor" => $doctor->name??'',
//                "date" => \Carbon\Carbon::parse($booking->check_in)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')
//            ),
//            "tracking_id" => 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'
//        );
//
//        $headers = array(
//            'access_token: '.$data['access_token'],
//            'Content-Type: application/json'
//        );
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://business.openapi.zalo.me/message/template',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => json_encode($postData),
//            CURLOPT_HTTPHEADER => $headers,
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
//
//        return $response;
//    }
//
//    public function sendZaloMessageOrder($order,$user,$hospital,$specialist,$doctor)
//    {
//        $data = $this->getTokenZaloZns();
//        if ($data['status'] == false) {
//            return back()->with(['error' => 'Refresh Token đã hết hạn']);
//        }
//        $phoneNumber = '84' . substr($user->phone, 1);
//        $curl = curl_init();
//
//        $postData = array(
//            "phone" => $phoneNumber,
//            "template_id" => "334492",
//            "template_data" => array(
//                "name" => $order->full_name,
//                "order_code" => 'BVPK'.rand(0, 9999).$order->id,
//                "specialist"=> $specialist,
//                "custom_url"=>'home%2Fbooking-detail%2F'.$hospital->id,
//                "doctor" => $doctor->name??'',
//                "date" => \Carbon\Carbon::parse($booking->check_in)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')
//            ),
//            "tracking_id" => 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'
//        );
//
//        $headers = array(
//            'access_token: '.$data['access_token'],
//            'Content-Type: application/json'
//        );
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => 'https://business.openapi.zalo.me/message/template',
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => json_encode($postData),
//            CURLOPT_HTTPHEADER => $headers,
//        ));
//
//        $response = curl_exec($curl);
//
//        curl_close($curl);
//
//        return $response;
//    }
}
