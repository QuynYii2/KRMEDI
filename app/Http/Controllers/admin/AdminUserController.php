<?php

namespace App\Http\Controllers\admin;

use App\Enums\DepartmentStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;

class AdminUserController extends Controller
{
    public function list()
    {
        return view('admin.user.list');
    }

    public function detail($id)
    {
        $user = User::find($id);
        if (!$user || $user->status == UserStatus::DELETED){
            alert()->error('Not found!');
            return back();
        }
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        return view('admin.user.detail', compact('departments', 'user'));
    }

    public function create()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        return view('admin.user.create', compact('departments'));
    }
}
