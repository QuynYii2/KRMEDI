<?php

namespace App\Http\Controllers\restapi;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;

class AccountApi extends Controller
{
    public function sendCode(Request $request)
    {
        try {
            $email = $request->input('email');

            if (!$email) {
                return response((new MainApi())->returnMessage('Email not empty!'), 400);
            }

            $code = (new MainController())->generateRandomNumber(6);

            $user = User::where('email', $email)->where('status', '!=', UserStatus::DELETED)->first();

            if ($user) {
                $user->verify_code = $code;
                $user->save();

                $data = [
                    'code' => $code,
                    'email' => $email,
                ];
                $mail_service = new MailController();
                $url = 'ui.mail.send-code-reset-device';
                $subject = 'VERIFICATION EMAIL';
                $mailFrom = 'support.il.vietnam@gmail.com';
                $title = 'VERIFICATION EMAIL';
                $mail_service->sendMailBlade($data, $email, $url, $subject, $mailFrom, $title);
                $response = [
                    'message' => 'Send mail success!',
                    'user_id' => $user->id
                ];
                return response()->json($response);
            }
            return response((new MainApi())->returnMessage('User not found!'), 404);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }

    public function resetTokenLogin(Request $request, $id)
    {
        try {
            $code = $request->input('code');

            if (!$code) {
                return response((new MainApi())->returnMessage('Email not empty!'), 400);
            }

            $user = User::find($id);

            if ($user && $user->status != UserStatus::DELETED) {
                if ($user->verify_code != $code) {
                    return response((new MainApi())->returnMessage('Verify code incorrect!'), 400);
                }

                if ($user->token && $user->token != '') {
                    (new MainController())->parsedToken($user->token);
                }

                $user->verify_code = null;
                $user->token = null;
                $user->save();

                return response((new MainApi())->returnMessage('Reset device success! Please login to continue!!!'), 200);
            }
            return response((new MainApi())->returnMessage('User not found!'), 404);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, please try again!'), 400);
        }
    }
}
