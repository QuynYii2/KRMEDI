<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class ChatMessageController extends Controller
{
    public function index()
    {
        return view('message.chat-message');
    }

    public function checkDoctorOnline($id)
    {
        $isOnline = Cache::has('user-is-online|' . $id);

        return response()->json(['isOnline' => $isOnline]);
    }
}
