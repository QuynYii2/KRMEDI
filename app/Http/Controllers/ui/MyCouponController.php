<?php

namespace App\Http\Controllers\ui;

use App\Http\Controllers\Controller;

class MyCouponController extends Controller
{
    public function listMyCoupons()
    {
        return view('ui.my-coupons.list');
    }
}
