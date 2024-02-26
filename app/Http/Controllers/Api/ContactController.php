<?php

namespace App\Http\Controllers\Api;

use App\Enums\MessageStatus;
use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function getContactList($id)
    {
        $contacts = User::where('id', '!=', $id)->get();

        $listUserWasConnect = Chat::where('to_user_id', $id)
            ->orWhere('from_user_id', $id)
            ->get(['from_user_id', 'to_user_id'])
            ->toArray();

        $uniqueUserIds = array_unique(array_merge(array_column($listUserWasConnect, 'from_user_id'), array_column($listUserWasConnect, 'to_user_id')));

        $uniqueUserIds = array_diff($uniqueUserIds, [$id]);

        $listContact = User::whereIn('id', $uniqueUserIds)->get();

        $unreadIds = Message::select(DB::raw(' `from` as sender_id, count(`from`) as messages_count'))->where('to',
                $id)->where('read', false)->groupBy('from')->get();

        $contacts = $listContact->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($contacts);
    }

    public function getMessages($id, $auth_id)
    {
        Message::where('from', $id)->where('to', $auth_id)->update(['read' => true]);
        Chat::where('from_user_id', $id)->where('to_user_id', $auth_id)->update(['message_status' => MessageStatus::SEEN]);

        $messages = Message::where('from', $id)->orwhere('to', $id)->get();

        return response()->json($messages);
    }

    public function sendNewMessage(Request $request)
    {
        if ($request->uuid_session) {
            $uuid = $request->uuid_session;
        } else {
            $uuid = Uuid::uuid();
        }

        $message = Message::create([
            'from' => $request->sender_id,
            'to' => $request->receiver_id,
            'text' => $request->text,
            'uuid_session' => $uuid,
        ]);

        Chat::create([
            'from_user_id' => $request->sender_id,
            'to_user_id' => $request->receiver_id,
            'chat_message' => $request->text,
            'message_status' => MessageStatus::UNSEEN,
            'uuid_session' => $uuid,
        ]);
        broadcast(new NewMessage($message));
        return response()->json($message);
    }

    public function renewUuidMessage(Request $request)
    {
        if ($request->uuid_session) {
            $uuid = $request->uuid_session;
        } else {
            $uuid = Uuid::uuid();
        }

        $type = 'TaoDonThuoc';

        $message = Message::create([
            'from' => $request->sender_id,
            'to' => $request->receiver_id,
            'text' => 'Bạn chưa có đơn thuốc',
            'uuid_session' => $uuid,
            'type' => $type,
        ]);

        Chat::create([
            'from_user_id' => $request->sender_id,
            'to_user_id' => $request->receiver_id,
            'chat_message' => 'Bạn chưa có đơn thuốc',
            'message_status' => MessageStatus::UNSEEN,
            'uuid_session' => $uuid,
            'type' => $type,
        ]);
        broadcast(new NewMessage($message));
        return response()->json($message);
    }
}
