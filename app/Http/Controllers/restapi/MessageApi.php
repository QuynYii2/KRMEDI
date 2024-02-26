<?php

namespace App\Http\Controllers\restapi;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class MessageApi extends Controller
{
    public function create(Request $request)
    {
        try {
            $message = new Chat();
            $from_user = $request->input('from_user_id');
            $to_user = $request->input('to_user_id');
            $content = $request->input('content');

            if ($request->hasFile('file_message')) {
                $item = $request->file('file_message');
                $itemPath = $item->store('message/file', 'public');
                $file = asset('storage/' . $itemPath);
                $message->files = $file;
            }

            $message->from_user_id = $from_user;
            $message->to_user_id = $to_user;
            $message->chat_message = $content;
            $message->message_status = MessageStatus::UNSEEN;

            $success = $message->save();
            if ($success) {
                $array = [
                    'status' => '200',
                    'message' => 'Create success',
                    'data' => $message
                ];
                return response()->json($array);
            }
            return response('Create error!', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }
}
