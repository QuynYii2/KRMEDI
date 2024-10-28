<?php

namespace App\Http\Controllers;

use App\Jobs\booking\ProcessBooking;
use App\Models\Booking;
use App\Models\CheckInBookingModel;
use App\Models\ZaloOaModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function check_mobile ()
    {
        $agent = new \Jenssegers\Agent\Agent;

        $result = $agent->isPhone();
        return $result;
    }

    public function getTokenAhamove()
    {
        $response = Http::withHeaders([
            'cache-control' => 'no-cache',
        ])->get('https://apistg.ahamove.com/v1/partner/register_account', [
            'mobile' => '0973566792',
            'name' => 'KRMEDI',
            'api_key' => 'c7a362387a0fe2e7ed2f3ee6e0df8ded726a9ea8',
            'address' => 'La Khe, Ha Dong',
        ]);

        $token = $response->json()['token'];
        return $token;
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

    public function processBooking($clinicId, $user)
    {
        $currentDateTime = now();

        $bookingApi = new Booking();
        $bookingApi->check_in = $currentDateTime->format('Y-m-d H:i:s');
        $bookingApi->check_out = $currentDateTime->addHour()->format('Y-m-d H:i:s');
        $bookingApi->clinic_id = $clinicId;
        $bookingApi->user_id  = $user->id;
        $bookingApi->type  = 1;
        $bookingApi->save();

        $newBooking = Booking::with('user', 'clinic.users')->find($bookingApi->id);
        if ($newBooking) {
            ProcessBooking::dispatch($newBooking);
        }

        $check_in_booking = new CheckInBookingModel();
        $check_in_booking->clinic_id = $clinicId;
        $check_in_booking->user_id = $user->id;
        $check_in_booking->save();
    }

    /**
     * get access token kiot viet
     */
    public function getAccessToken()
    {
        $clientId = '28eaf390-fc63-486e-b45c-bbc303090296';
        $clientSecret = 'E02FEB39EB68969E3E0F1A7AEE9B2955910B283F';
        $endpoint = 'https://id.kiotviet.vn/connect/token';

        $response = Http::asForm()->post($endpoint, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => 'PublicApi.Access',
        ]);

        $data = $response->json();

        return $data['access_token'];
    }

    /**
     * get hàng hóa kiot viet
     */
    public function getGoodsKiotViet($token)
    {
        $accessToken = $token;
        $endpoint = 'https://public.kiotapi.com/categories';
        $queryParameters = [
            'pageSize' => 100,
        ];

        $endpoint .= '?' . http_build_query($queryParameters);
        $response = Http::withHeaders([
            'Retailer' => 'krmedi',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($endpoint);

        $data = $response->json();

        return $data;
    }

    /**
     * get chi tiết san pham kiot viet
     */
    public function getProductsKiotViet($token, $id)
    {
        $accessToken = $token;
        $endpoint = 'https://public.kiotapi.com/products/' . $id;
        $response = Http::withHeaders([
            'Retailer' => 'krmedi',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get($endpoint);

        $data = $response->json();

        return $data;
    }

}
