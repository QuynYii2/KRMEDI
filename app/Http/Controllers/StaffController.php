<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Department;
use App\Models\ProductInfo;
use App\Models\ServiceClinic;
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
        $serviceClinic = ServiceClinic::all();
        $departmentClinic = Department::all();
        return view('admin.staff.tab-create-staff',compact('serviceClinic','departmentClinic'));
    }

    public function edit($id)
    {
        //find user by id
        $user = User::find($id);
        $serviceClinic = ServiceClinic::all();
        $departmentClinic = Department::all();
        return view('admin.staff.tab-edit-staff', compact('user','serviceClinic','departmentClinic'));
    }
}
