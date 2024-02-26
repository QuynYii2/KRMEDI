<?php

namespace App\Http\Controllers;

class OrderController extends Controller
{
    public function index()
    {
        return view('ui.orders.list');
    }
}
