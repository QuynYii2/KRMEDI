<?php

namespace App\Http\Controllers;

use App\Enums\Constants;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Zalo\Builder\MessageBuilder;
use Zalo\Util\PKCEUtil;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class ZaloController extends Controller
{
    protected $app_id = Constants::ID_ZALO_APP;
    protected $app_secret = Constants::KEY_ZALO_APP;
    protected $access_token;
    protected $app_redirect = 'https%3A%2F%2Fkrmedi.vn%2Fzalo-service%2Fcallback';
    protected $app_url_permission = 'https://oauth.zaloapp.com/v4/oa/permission';
    protected $app_url_token = 'https://oauth.zaloapp.com/v4/oa/access_token';

    public function __construct()
    {
        $this->access_token = $_COOKIE['access_token_zalo'] ?? null;
    }

    /* Create new zalo */
    public function main()
    {
        $config = array(
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret
        );
        $zalo = new Zalo($config);

        return $zalo;
    }

    /* Get code of my OA */
    public function getAuthCode()
    {
        $url = $this->getLoginUrlOA();
        return redirect($url);
    }

    /* Get code and redirect to url */
    public function getParameter(Request $request)
    {
        $parameters = $request->all();
        $code = $parameters['code'];

        $url_redirect = route('zalo.service.token') . '?code=' . $code;
        return redirect($url_redirect);
    }

    /* Set code to cookie */
    public function getToken(Request $request)
    {
        $code = $request->input('code');
        $array_token = $this->getAccessToken($code);
        $dataToken = null;
        if ($array_token['status'] == 200) {
            $dataToken = $array_token['data'];
        }
        $array = json_decode($dataToken, true);
        if (isset($array['access_token'])) {
            $expiration_time = time() + $array['expires_in'];
            setCookie('access_token_zalo', $array['access_token'], $expiration_time, '/');
            setCookie('refresh_token_zalo', $array['refresh_token'], $expiration_time, '/');
        }
        return redirect(route('home'));
    }

    /* Get user follow*/
    public function getFollower()
    {
        $data = [
            'data' => json_encode([
                'offset' => 0,
                'count' => 50
            ])
        ];
        $zalo = $this->main();
        $accessToken = $_COOKIE['access_token_zalo'] ?? null;
        $response = $zalo->get(ZaloEndPoint::API_OA_GET_LIST_FOLLOWER, $accessToken, $data);

        return $response->getDecodedBody();
    }

    /* Send message */
    public function sendMessage(Request $request)
    {
        $user_id = $request->input('user_zalo');
        $message = $request->input('message');
        return $this->sendMessageText($user_id, $message);
    }

    public function sendMessageText($user_id, $message)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->withText($message);

        $msgText = $msgBuilder->build();
        $zalo = $this->main();
        $accessToken = $_COOKIE['access_token_zalo'] ?? null;
        $response = $zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accessToken, $msgText);
        return $response->getDecodedBody();
    }

    /* Get profile */
    public function getProfile(Request $request)
    {
        $user_id = $request->input('user_zalo');
        $data = ['data' => json_encode(array(
            'user_id' => $user_id
        ))];
        $zalo = $this->main();
        $accessToken = $_COOKIE['access_token_zalo'] ?? null;
        $response = $zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $accessToken, $data);
        $result = $response->getDecodedBody();
        return $result;
    }

    private function getLoginUrlOA()
    {
        $url = $this->app_url_permission;

        $codeChallenge = '';
        $state = '';

        $app_id_url = '?app_id=' . $this->app_id;
        $redirect_url = '&redirect_uri=' . $this->app_redirect;
        $challenge_url = '&code_challenge=' . $codeChallenge;
        $state_url = '&state=' . $state;

        return $url . $app_id_url . $redirect_url;
    }

    private function getAccessToken($code)
    {
        try {
            $client = new Client();

            $response = $client->post($this->app_url_token, [
                'headers' => [
                    'secret_key' => $this->app_secret,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'code' => $code,
                    'app_id' => $this->app_id,
                    'grant_type' => 'authorization_code',
                ],
            ]);

            return [
                'data' => $response->getBody()->getContents(),
                'status' => 200,
            ];
        } catch (\Exception $exception) {
            return [
                'data' => $exception->getMessage(),
                'status' => 500,
            ];
        }
    }
}
