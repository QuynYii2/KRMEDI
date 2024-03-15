<?php

namespace App\Http\Controllers\backend;

use AhamoveEndPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendAhamoveController extends Controller
{
    public function test()
    {
        AhamoveEndPoint::API_AHA_GET_TOKEN;
    }
}
