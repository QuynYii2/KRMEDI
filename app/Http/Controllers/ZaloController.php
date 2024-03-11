<?php

namespace App\Http\Controllers;

use App\Enums\Constants;
use App\Models\User;
use App\Models\ZaloFollower;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\FileUpload\ZaloFile;
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
    protected $auth_zalo_app = 'https://oauth.zaloapp.com/v4/permission';

    private $zalo;

    public function __construct($access_token = null)
    {
        $this->access_token = $access_token ?? $_COOKIE['access_token_zalo'] ?? null;
        $this->zalo = $this->main();
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
    public function getAuthCode($isRedirect = true)
    {
        $url = $this->getLoginUrlOA();
        if (!$isRedirect) {
            return $url;
        }
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

            $user = User::find(Auth::user()->id);

            if ($user) {
                if ($user->extend === null) {
                    $user->extend = json_encode([
                        'access_token_zalo' => $array['access_token'],
                        'refresh_token_zalo' => $array['refresh_token']
                    ]);
                } else {
                    $extendData = json_decode($user->extend, true);
                    $extendData['access_token_zalo'] = $array['access_token'];
                    $extendData['refresh_token_zalo'] = $array['refresh_token'];
                    $user->extend = json_encode($extendData);
                }

                $user->save();
            }
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

        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_FOLLOWER, $this->access_token, $data);

        return $response->getDecodedBody();
    }

    /* Send message */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message_type' => 'required|in:text,file,photo',
            'message' => $request->input('message_type') === 'text' ? 'required' : '',
            'file_attached' => 'required_if:message_type,file|file|mimes:pdf,doc,docx|max:5120', // Max 5MB as zalo requirement
            'photoMessage' => $request->input('message_type') === 'photo' && $request->input('photo_type') === 'image' ? 'required' : '',
            'photo_attached' => $request->input('message_type') === 'photo' && $request->input('photo_type') === 'image' ? 'required|file|image|mimes:jpg,png|max:1024' : '',
            'gif_attached' => $request->input('message_type') === 'photo' && $request->input('photo_type') === 'gif' ? 'required|file|mimes:gif|max:5120' : ''
        ]);

        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error', 'top-left');
            return back();
        }

        $userId = $request->input('user_zalo');
        switch ($request->input('message_type')) {
            case 'text':
                $message = $request->input('message');
                $this->sendMessageText($userId, $message);
                break;
            case 'file':
                //Save file -> get URL -> get token -> send msg ft token with uploaded file from zalo
                if ($request->hasFile('file_attached')) {
                    $item = $request->file('file_attached');
                    $itemPath = $item->store('zalo_file', 'public');
                    $itemUrl = url('storage/' . $itemPath);
                    $filePayloadToken = $this->uploadFile($itemUrl, $this->access_token);

                    $this->sendMessageFile($userId, $filePayloadToken);
                    toast('Successfully', 'success', 'top-left');
                } else {
                    toast('Something went wrong', 'error', 'top-left');
                }
                break;
            case 'photo':
                $message = $request->input('photoMessage');
                if ($request->input('photo_type') === 'image') {
                    //PNG + JPG
                    if ($request->hasFile('photo_attached')) {
                        $item = $request->file('photo_attached');
                        $itemPath = $item->store('zalo_image', 'public');
                        $itemUrl = url('storage/' . $itemPath);
                        $attachmentId = $this->uploadImage($itemUrl, $this->access_token);

                        $this->sendMessageWithImage($userId, $message, $attachmentId);
                        toast('Successfully', 'success', 'top-left');
                    } else {
                        toast('Something went wrong', 'error', 'top-left');
                    }
                } elseif ($request->input('photo_type') === 'gif') {
                    //GIF
                    if ($request->hasFile('gif_attached')) {
                        $item = $request->file('gif_attached');
                        $itemPath = $item->store('zalo_gif', 'public');
                        $itemUrl = url('storage/' . $itemPath);
                        $attachmentId = $this->uploadGif($itemUrl, $this->access_token);

                        $this->sendMessageWithGif($userId, $attachmentId);
                        toast('Successfully', 'success', 'top-left');
                    } else {
                        toast('Something went wrong', 'error', 'top-left');
                    }
                }
                break;
            default:
                toast('Something went wrong', 'error', 'top-left');
                return back();
        }
        return back();
    }

    // Gửi tin nhắn dạng văn bản
    public function sendMessageText($user_id, $message)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId($user_id);
        $msgBuilder->withText($message);

        $msgText = $msgBuilder->build();
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->access_token, $msgText);
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

            // send request
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->access_token, $msgText);
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

            $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $this->access_token, $data);
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

    //Get access token from refresh token
    private function getRefreshAccessToken($refresh_token)
    {
        try {
            $client = new Client();

            $response = $client->post($this->app_url_token, [
                'headers' => [
                    'secret_key' => $this->app_secret,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'refresh_token' => $refresh_token,
                    'app_id' => $this->app_id,
                    'grant_type' => 'refresh_token',
                ],
            ]);

            $data = $response->getBody()->getContents();
            $array_data = json_decode($data, true);

            $user = User::find(Auth::user()->id);

            if ($user) {
                if ($user->extend === null) {
                    $user->extend = json_encode([
                        'access_token_zalo' => $array_data['access_token'],
                        'refresh_token_zalo' => $array_data['refresh_token']
                    ]);
                } else {
                    $extendData = json_decode($user->extend, true);
                    $extendData['access_token_zalo'] = $array_data['access_token'];
                    $extendData['refresh_token_zalo'] = $array_data['refresh_token'];
                    $user->extend = json_encode($extendData);
                }

                $user->save();
            }

            return [
                'data' => $data,
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
        try {
            $follower_info = ZaloFollower::latest('updated_at')->get();

            return view('admin.user.zalo')->with(compact('follower_info'));
        } catch (Throwable $e) {
            toast($e->getMessage(), 'error', 'top-left');
            return back();
        }
    }

    public function syncFollower()
    {
        try {
            if ($this->access_token == null) {
                $refresh_token = json_decode(Auth::user()->extend)->refresh_token_zalo ?? null;
                if ($refresh_token) {
                    try {
                        $array_token = $this->getRefreshAccessToken($refresh_token);
                        $dataToken = null;
                        if ($array_token['status'] == 200) {
                            $dataToken = $array_token['data'];
                        }
                        $array = json_decode($dataToken, true);
                        if (isset($array['access_token'])) {
                            $expiration_time = time() + $array['expires_in'];
                            setCookie('access_token_zalo', $array['access_token'], $expiration_time, '/');
                            setCookie('refresh_token_zalo', $array['refresh_token'], $expiration_time, '/');
                            $this->access_token = $array['access_token'];
                        }
                    } catch (Exception $e) {
                        // Handle the exception
                        // Logged to OA
                        session()->put('zalo_intended_url', request()->url());
                        return response()->json(['redirectUrl' => $this->getAuthCode(false)]);
                    }
                } else {
                    // Logged to OA
                    session()->put('zalo_intended_url', request()->url());
                    return response()->json(['redirectUrl' => $this->getAuthCode(false)]);
                }
            }

            $followers = $this->getFollower()['data']['followers'] ?? [];

            foreach ($followers as $follower) {
                $user_id = $follower['user_id'];
                $request = new Request();
                $request->merge(['user_zalo' => $user_id]);

                try {
                    $result = $this->getProfile($request);

                    if ($result instanceof JsonResponse) {
                        throw new Exception('An error occurred while getting the profile.');
                    }

                    if (isset($result['data']['shared_info']) && is_array($result['data']['shared_info'])) {
                        $sharedInfo = $result['data']['shared_info'];
                        $name = $sharedInfo['name'] ?? $result['data']['display_name'];
                        $address = $sharedInfo['address'] ?? '';
                        $district = $sharedInfo['district'] ?? '';
                        $city = $sharedInfo['city'] ?? '';

                        $addressString = $address . '</br>' . $district . '</br>' . $city;

                        $phone = $sharedInfo['phone'] ?? null;
                        // Check if the string is a regular expression
                        if ($phone && preg_match('/^\d{11}$/', $phone)) {
                            $convertedPhone = '0' . substr($phone, 2);
                        } else {
                            $convertedPhone = $phone;
                        }
                    } else {
                        $name = $result['data']['display_name'];
                        $addressString = '';
                        $convertedPhone = null;
                    }

                    ZaloFollower::updateOrCreate(
                        ['user_id' => $user_id],
                        [
                            'avatar' => $result['data']['avatar'],
                            'name' => $name,
                            'user_id_by_app' => $result['data']['user_id_by_app'],
                            'phone' => $convertedPhone,
                            'address' => $addressString
                        ]
                    );
                } catch (Throwable $e) {
                    // Handle the exception for profile retrieval
                    ZaloFollower::updateOrCreate(
                        ['user_id' => $user_id],
                        [
                            'name' => 'Banned User',
                            'user_id' => $user_id
                        ]
                    );
                }
            }

            return response()->json(['success' => true, 'data' => $this->manageFollower()]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
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
            $helper = $this->zalo->getRedirectLoginHelper();
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
            $helper = $this->zalo->getRedirectLoginHelper();
            $zaloToken = $helper->getZaloToken($codeVerifier);
            $accessToken = $zaloToken->getAccessToken();
            return $accessToken;
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to retrieve user access token: " . $e->getMessage());
        }
    }

    //Lấy thông tin người dùng & check accesstoken hết hạn hay k
    public function getUserInformation($userAccessToken)
    {
        try {
            $params = ['fields' => 'id,name,picture'];
            $response = $this->zalo->get(ZaloEndPoint::API_GRAPH_ME, $userAccessToken, $params);
            $result = $response->getDecodedBody(); // result
            return $result;
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to retrieve user information: " . $e->getMessage());
        }
    }

    //Upload file to zalo
    public function uploadFile($filePath)
    {
        try {
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_FILE, $this->access_token, $data);
            $result = $response->getDecodedBody(); // result
            return $result['data']['token'];
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to upload file: " . $e->getMessage());
        }
    }

    //Upload photo(image) to zalo
    public function uploadImage($filePath)
    {
        try {
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_PHOTO, $this->access_token, $data);
            $result = $response->getDecodedBody(); // result
            return $result['data']['attachment_id'];
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to upload file: " . $e->getMessage());
        }
    }

    //Upload photo(gif) to zalo
    public function uploadGif($filePath)
    {
        try {
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_GIF, $this->access_token, $data);
            $result = $response->getDecodedBody(); // result
            return $result['data']['attachment_id'];
        } catch (\Exception $e) {
            // Handle the exception
            throw new \Exception("Failed to upload file: " . $e->getMessage());
        }
    }

    //Gửi tin nhắn dạng file
    public function sendMessageFile($userId, $payloadToken)
    {
        $msgBuilder = new MessageBuilder('file');
        $msgBuilder->withUserId($userId);
        $msgBuilder->withFileToken($payloadToken);
        $msgFile = $msgBuilder->build();
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->access_token, $msgFile);
        $result = $response->getDecodedBody(); // result
        if ($result['error'] != 0) {
            //Err
            toast('Something went wrong', 'error', 'top-left');
        }
        toast('Successfully', 'success', 'top-left');
    }

    //Gửi tin nhắn Tư vấn đính kèm hình ảnh
    public function sendMessageWithImage($userId, $message, $attachmentId)
    {
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId($userId);
        $msgBuilder->withText($message);
        $msgBuilder->withAttachment($attachmentId);

        $msgImage = $msgBuilder->build();

        // send request
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->access_token, $msgImage);
        $result = $response->getDecodedBody();
        if ($result['error'] != 0) {
            //Err
            toast('Something went wrong', 'error', 'top-left');
        }
        toast('Successfully', 'success', 'top-left');
    }

    //Gửi tin nhắn dạng Gif
    public function sendMessageWithGif($userId, $attachmentId)
    {
        $msgBuilder = new MessageBuilder('media');
        $msgBuilder->withUserId($userId);
        $msgBuilder->withAttachment($attachmentId);
        $msgBuilder->withMediaType('gif');
        $msgBuilder->withMediaSize(120, 120); //Default
        $msgImage = $msgBuilder->build();

        $response = $this->zalo->post(ZaloEndpoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->access_token, $msgImage);
        $result = $response->getDecodedBody(); // result
        if ($result['error'] != 0) {
            //Err
            toast('Something went wrong', 'error', 'top-left');
        }
        toast('Successfully', 'success', 'top-left');
    }

    //API check user login = zalo existed?
    public function userExisted($app_id)
    {
        try {
            $user = User::where('provider_name', 'zalo')->where('provider_id', $app_id)->first();

            if ($user) {
                $role = $user->roles()->first();
                $token = JWTAuth::fromUser($user);
                $user->token = $token;
                $user->save();
                $user->role = $role->name ?? "";
                return response()->json($user);
            }

            throw new \Exception('User not found');
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()], 404);
        }
    }

    //Gửi tin nhắn thông tin giao dịch booking cho người dùng
    public function sendBookingMessage(Request $request, $isOAReceived = false)
    {
        try {
            //Gửi cho OA
            if ($isOAReceived) {
                $userId = $request->user_id;
                $clinic = $request->booking_clinic;
                $clinicId = $request->booking_clinic_id;
                $checkInTime = $request->booking_clinic_checkin;
                $userName = $request->user_name;

                $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_PROMOTION);
                $msgBuilder->withUserId($userId);

                $bannerElement = array(
                    'image_url' => 'https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/311942959/original/c064dac2df0c204b234b395ece39fa4f9d87661e/medical-website-healthcare-website-clinic-website-doctor-website-dental-website-22dd.jpg',
                    'type' => 'banner'
                );
                $msgBuilder->addElement($bannerElement);

                $headerElement = array(
                    'content' => 'Có lịch hẹn mới',
                    'align' => 'left',
                    'type' => 'header'
                );
                $msgBuilder->addElement($headerElement);

                $text1Element = array(
                    'align' => 'left',
                    'content' => '• Lịch hẹn mới tại: ' . $clinic . '<br>• Hãy kiểm tra hồ sơ người bệnh:',
                    'type' => 'text'
                );
                $msgBuilder->addElement($text1Element);

                $tableContent2 = array(
                    'key' => 'Tên người bệnh',
                    'value' => $userName
                );

                $tableContent3 = array(
                    'key' => 'Thời gian bắt đầu',
                    'value' => $checkInTime
                );
                $tableElement = array(
                    'content' => array($tableContent2, $tableContent3),
                    'type' => 'table'
                );
                $msgBuilder->addElement($tableElement);

                $text2Element = array(
                    'content' => '📆 Hãy để ý lịch và thông báo. Xin cảm ơn!',
                    'align' => 'center',
                    'type' => 'text'
                );

                $msgBuilder->addElement($text2Element);

                $actionOpenUrl = $msgBuilder->buildActionOpenURL(route('homeAdmin.list.booking'));
                $msgBuilder->addButton('Kiểm tra lịch khám', '', $actionOpenUrl);

                $msgPromotion = $msgBuilder->build();

                // send request
                $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_PROMOTION_MESSAGE_V3, $this->access_token, $msgPromotion);
                $result = $response->getDecodedBody();
                return $result;
            }
            //Gửi cho người dùng
            $userId = $request->user_id;
            $clinic = $request->booking_clinic;
            $clinicId = $request->booking_clinic_id;
            $checkInTime = $request->booking_clinic_checkin;
            $name = $request->user_name;
            $bookingStatus = $request->booking_status;
            $bookingCancelReason = $request->booking_cancel_reason;

            $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_PROMOTION);
            $msgBuilder->withUserId($userId);

            $bannerElement = array(
                'image_url' => 'https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/311942959/original/c064dac2df0c204b234b395ece39fa4f9d87661e/medical-website-healthcare-website-clinic-website-doctor-website-dental-website-22dd.jpg',
                'type' => 'banner'
            );
            $msgBuilder->addElement($bannerElement);

            $headerElement = array(
                'content' => 'Trạng thái lịch hẹn',
                'align' => 'left',
                'type' => 'header'
            );
            $msgBuilder->addElement($headerElement);

            $text1Element = array(
                'align' => 'left',
                'content' => '• Cảm ơn bạn đã đặt lịch tại: ' . $clinic . '<br>• Hãy kiểm tra lịch hẹn của bạn:',
                'type' => 'text'
            );
            $msgBuilder->addElement($text1Element);

            $tableContent1 = array(
                'key' => 'Tên người bệnh',
                'value' => $name
            );

            switch ($bookingStatus) {
                case 'PENDING':
                    $tableContent2 = array(
                        'key' => 'Trạng thái',
                        'value' => 'Đang chờ',
                        'style' => 'yellow',
                    );
                    break;
                case 'COMPLETE':
                    $tableContent2 = array(
                        'key' => 'Trạng thái',
                        'value' => 'Hoàn thành',
                        'style' => 'green',
                    );
                    break;
                case 'APPROVED':
                    $tableContent2 = array(
                        'key' => 'Trạng thái',
                        'value' => 'Được duyệt',
                        'style' => 'blue',
                    );
                    break;
                case 'CANCEL':
                    $tableContent2 = array(
                        'key' => 'Trạng thái',
                        'value' => 'Bị huỷ (' . $bookingCancelReason . ')',
                        'style' => 'red',
                    );
                    break;

                default:
                    $tableContent2 = array(
                        'key' => 'Trạng thái',
                        'value' => 'Something went wrong',
                        'style' => 'grey',
                    );
                    break;
            }

            $tableContent3 = array(
                'key' => 'Thời gian bắt đầu',
                'value' => $checkInTime
            );
            $tableElement = array(
                'content' => array($tableContent1, $tableContent2, $tableContent3),
                'type' => 'table'
            );
            $msgBuilder->addElement($tableElement);

            if ($bookingStatus == "CANCEL") {
                $text2Element = array(
                    'content' => '🤕 Chúng tôi rất xin lỗi vì phải huỷ lịch đặt của bạn!',
                    'align' => 'center',
                    'type' => 'text'
                );
            } else {
                $text2Element = array(
                    'content' => '📆 Hãy để ý lịch và thông báo. Xin cảm ơn!',
                    'align' => 'center',
                    'type' => 'text'
                );
            }
            $msgBuilder->addElement($text2Element);

            $actionOpenUrl = $msgBuilder->buildActionOpenURL(route('web.users.my.bookings.list'));
            $msgBuilder->addButton('Kiểm tra lịch khám', '', $actionOpenUrl);

            if ($bookingStatus == "CANCEL") {
                $actionOpenUrl = $msgBuilder->buildActionOpenURL(route('clinic.detail', $clinicId));
                $msgBuilder->addButton('Đặt lại lịch', 'https://static.vecteezy.com/system/resources/previews/010/160/988/original/calendar-icon-sign-symbol-design-free-png.png', $actionOpenUrl);
            }

            $msgPromotion = $msgBuilder->build();

            // send request
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_PROMOTION_MESSAGE_V3, $this->access_token, $msgPromotion);
            $result = $response->getDecodedBody();
            return $result;
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()], 404);
        }
    }
}
