<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function needHelp()
    {
        return view('ui.need-helps.need-help');
    }
}
