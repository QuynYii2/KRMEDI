<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail($mailTo, $mailFrom, $subject, $content)
    {
        Mail::send([], [], function ($message) use ($mailTo, $content, $mailFrom, $subject) {
            $message->to($mailTo, $subject)
                ->subject($subject);

            $message->from($mailFrom, config('mail.from.name'));
            $message->text($content);
        });
    }

    public function sendMailBlade($data, $email, $url, $subject, $mailFrom, $title)
    {
        // url ở đây là đừong dẫn đến blade mà bạn muốn gửi
        // title là tiêu đề của mail
        // data là dữ liệu muốn gửi kèm trong mail
        // email là email nhận mail
        // mailTo là email gửi
        Mail::send($url, $data, function ($message) use ($email, $subject, $mailFrom, $title) {
            $message->to($email, $subject)->subject($subject);
            $message->from($mailFrom, $title);
        });
    }

    public function sendEmailFromRequest(Request $request)
    {
        $mailFrom = $request->input('mail_from');
        $mailTo = $request->input('mail_to');
        $subject = $request->input('title');
        $content = $request->input('message');

        $user = User::where('email', $mailTo)->first();

        // Mọi kí tự cần thay thế phải đặt trong dấu !! ở điểm bắt đầu và kết thúc đồng thời viết hoa
        $content = str_replace("!!NAME!!", $user->username, $content);
        $content = str_replace("!!EMAIL!!", $user->email, $content);
        $content = str_replace("!!PHONE_NUMBER!!", $user->phone, $content);

        Mail::send([], [$request], function ($message) use ($mailTo, $content, $mailFrom, $subject) {
            $message->to($mailTo, $subject)
                ->subject($subject);

            $message->from($mailFrom, $subject);
            $message->text($content);
        });

        return response()->json(['message' => 'Email sent successfully']);
    }
}
