<?php

namespace App\Http\Controllers\connect;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function index()
    {
        $id = '';
        return view('admin.connect.chat.index', compact('id'));
    }

    public function show()
    {
        return view('chat-message');
    }
}
