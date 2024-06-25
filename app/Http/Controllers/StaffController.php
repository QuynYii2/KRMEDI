<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Models\Department;
use App\Models\ProductInfo;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\ServiceClinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user_role = RoleUser::where('user_id',Auth::id())->first();
        $role = Role::find($user_role->role_id);
        return view('admin.staff.tab-create-staff',compact('serviceClinic','departmentClinic','role'));
    }

    public function edit($id)
    {
        //find user by id
        $user = User::find($id);
        $serviceClinic = ServiceClinic::all();
        $departmentClinic = Department::all();
        $user_role = RoleUser::where('user_id',Auth::id())->first();
        $role = Role::find($user_role->role_id);
        return view('admin.staff.tab-edit-staff', compact('user','serviceClinic','departmentClinic','role'));
    }
}
