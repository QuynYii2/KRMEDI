<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\ProductInfo;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function show($id)
    {
        $product = '';
        return response()->json($product);
    }

    public function create()
    {
        return view('admin.staff.tab-create-staff');
    }

    public function edit($id)
    {
        //find user by id
        $user = User::find($id);
        return view('admin.staff.tab-edit-staff', compact('user'));
    }
}
