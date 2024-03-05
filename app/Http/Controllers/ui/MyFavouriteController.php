<?php

namespace App\Http\Controllers\ui;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyFavouriteController extends Controller
{
    public function businessFavourite(Request $request)
    {
        return view('ui.my-favourite.list-business');
    }

    public function medicalFavourite(Request $request)
    {
        return view('ui.my-favourite.list-medical');
    }

    public function productFavourite(Request $request)
    {
        return view('ui.my-favourite.list-product');
    }
}
