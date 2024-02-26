<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;

class AccountController extends Controller
{

    public function needHelp()
    {
        RateLimiter::attempt()
        return view('ui.need-helps.need-help');

    }

    public function accountHelp()
    {
        return view('ui.need-helps.account.help-account');
    }

    public function resetToken()
    {
        return view('ui.need-helps.account.reset-token');
    }

    public function verifyCodeToken($id)
    {
        return view('ui.need-helps.verify-account', compact('id'));
    }
}
