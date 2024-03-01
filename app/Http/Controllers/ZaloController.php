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
use Illuminate\Support\Str;

class ZaloController extends Controller
{
    protected $app_id = Constants::ID_ZALO_APP;
    protected $app_secret = Constants::KEY_ZALO_APP;
    protected $access_token;
    protected $app_redirect = 'https%3A%2F%2Fkrmedi.vn%2Fzalo-service%2Fcallback';
    protected $app_url_permission = 'https://oauth.zaloapp.com/v4/oa/permission';
    protected $app_url_token = 'https://oauth.zaloapp.com/v4/oa/access_token';
    protected $auth_zalo_app = 'https://oauth.zaloapp.com/v4/permission';

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
        if (session('zalo_intended_url')) {
            return redirect(session('zalo_intended_url'));
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
        $this->sendMessageText($user_id, $message);
        return back();
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
        if ($response->getDecodedBody()['error'] != 0) {
            //Err
            toast('Something went wrong', 'error', 'top-left');
        }
        toast('Successfully', 'success', 'top-left');
    }

    public function sendInvitation(Request $request)
    {
        try {
            $user_id = $request->input('user_zalo');
            $title = $request->input('title');
            $subtitle = $request->input('subtitle');
            $image_url = $request->input('image_url');

            return $this->sendInvitationContent($user_id, $title, $subtitle, $image_url);
        } catch (\Exception $e) {
            // Exception handling code
            return response()->json(['error' => 'An error occurred while sending the invitation: ' . $e->getMessage()], 500);
        }
    }

    public function sendInvitationContent($user_id, $title, $subtitle, $image_url)
    {
        try {
            $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_REQUEST_USER_INFO);
            $msgBuilder->withUserId($user_id);

            $element = array(
                "title" => $title ?? "OA Chatbot",
                "subtitle" => $subtitle ?? "Đang yêu cầu thông tin từ bạn",
                "image_url" => $image_url ?? "https://stc-oa-chat-adm.zdn.vn/images/request-info-banner.png"
            );
            $msgBuilder->addElement($element);

            $msgText = $msgBuilder->build();

            $zalo = $this->main();
            $accessToken = $_COOKIE['access_token_zalo'] ?? null;

            // send request
            $response = $zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $accessToken, $msgText);
            return $response->getDecodedBody();
        } catch (\Exception $e) {
            // Exception handling code
            return response()->json(['error' => 'An error occurred while sending the invitation: ' . $e->getMessage()], 500);
        }
    }

    /* Get profile */
    public function getProfile(Request $request)
    {
        try {
            $user_id = $request->input('user_zalo');
            $data = ['data' => json_encode(array(
                'user_id' => $user_id
            ))];
            $zalo = $this->main();
            $accessToken = $_COOKIE['access_token_zalo'] ?? null;
            $response = $zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $accessToken, $data);
            $result = $response->getDecodedBody();
            return $result;
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while retrieving the profile: ' . $e->getMessage()], 500);
        }
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

    public function manageFollower()
    {
        if ($this->access_token == null) {
            //Logged to OA
            session()->put('zalo_intended_url', request()->url());
            return $this->getAuthCode();
        }

        $followers = $this->getFollower()['data']['followers'] ?? [];

        $follower_info = [];

        foreach ($followers as $follower) {
            $user_id = $follower['user_id'];
            $request = new Request();
            $request->merge(['user_zalo' => $user_id]);
            $result = $this->getProfile($request);

            if ($result instanceof \Illuminate\Http\JsonResponse) {
                $follower_info[] = [
                    'isBanned' => true,
                    'display_name' => 'Banned User',
                    'user_id' => $follower['user_id']
                ];

                continue;
            }
    
            if (isset($result['data']) && is_array($result['data'])) {
                $follower_info[] = $result['data'];
            }
        }

        return view('admin.user.zalo')->with(compact('follower_info'));
    }

    // Tạo code verifier
    public function generateCodeVerifier()
    {
        try {
            return PKCEUtil::genCodeVerifier();
        } catch (\Exception $e) {
            // Handle the exception
            // Log the error, display an error message, or perform any necessary actions
            throw new \Exception("Failed to generate code verifier: " . $e->getMessage());
        }
    }

    // Tạo code challenge từ code verifier
    public function generateCodeChallenge($codeVerifier)
    {
        try {
            return PKCEUtil::genCodeChallenge($codeVerifier);
        } catch (\Exception $e) {
            // Handle the exception
            // Log the error, display an error message, or perform any necessary actions
            throw new \Exception("Failed to generate code challenge: " . $e->getMessage());
        }
    }

    public function getAuthZaloUrl($codeChallenge, $state)
    {
        try {
            $zalo = $this->main();
            $helper = $zalo->getRedirectLoginHelper();
            $callbackUrl = route('login.zalo.callback');
            $loginUrl = $helper->getLoginUrl($callbackUrl, $codeChallenge, $state);
            return $loginUrl;
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to get Zalo authentication URL: " . $e->getMessage());
        }
    }

    public function getUserAccessToken($codeVerifier)
    {
        try {
            $zalo = $this->main();
            $helper = $zalo->getRedirectLoginHelper();
            $zaloToken = $helper->getZaloToken($codeVerifier);
            $accessToken = $zaloToken->getAccessToken();
            return $accessToken;
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to retrieve user access token: " . $e->getMessage());
        }
    }

    public function getUserInformation($userAccessToken)
    {
        try {
            $zalo = $this->main();
            $params = ['fields' => 'id,name,picture'];
            $response = $zalo->get(ZaloEndPoint::API_GRAPH_ME, $userAccessToken, $params);
            $result = $response->getDecodedBody(); // result
            return $result;
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to retrieve user information: " . $e->getMessage());
        }
    }
}
