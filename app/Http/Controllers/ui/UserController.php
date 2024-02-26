<?php

namespace App\Http\Controllers\ui;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function listRatingUser()
    {
        return view('ui.member-ratings.list-member');
    }
}
