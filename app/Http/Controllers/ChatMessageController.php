<?php

namespace App\Http\Controllers;

class ChatMessageController extends Controller
{
    public function index()
    {
        return view('message.chat-message');
    }
}
