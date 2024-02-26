<?php

namespace App\Http\Controllers;

use App\Enums\DepartmentStatus;
use App\Enums\DoctorInfoStatus;
use App\Enums\UserStatus;
use App\Models\Chat;
use App\Models\Department;
use App\Models\DoctorInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorInfoController extends Controller
{
    public function index()
    {
        //
    }

    public function show($id)
    {
        $coupon = DoctorInfo::find($id);
        if (!$coupon || $coupon->status != DoctorInfoStatus::ACTIVE) {
            return response("doctor not found", 404);
        }
        return response()->json($coupon, $id);
    }

    public function showFromQrCode($id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $doctor = User::find($id);
            $messageDoctor = Chat::where([
                ['from_user_id', $id],
                ['to_user_id', $user->id]
            ])->orWhere([
                ['to_user_id', $id],
                ['from_user_id', $user->id]
            ])->get();
            return view('qrCode.doctor-info', compact('messageDoctor', 'doctor'));
        }
        return redirect(route('home'));
    }

    public function create()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        $reflector = new \ReflectionClass('App\Enums\TypeMedical');
        $types = $reflector->getConstants();
        return view('admin.doctor.tab-create-doctor', compact('departments', 'types'));
    }

    public function listDepartment()
    {
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();

        return response()->json($departments);
    }

    public function edit($id)
    {
        $doctor = User::find($id);
        if (!$doctor || $doctor->status == UserStatus::DELETED) {
            return back();
        }
        $departments = Department::where('status', DepartmentStatus::ACTIVE)->get();
        $reflector = new \ReflectionClass('App\Enums\TypeMedical');
        $types = $reflector->getConstants();
        return view('admin.doctor.tab-edit-doctor', compact('doctor', 'departments', 'types'));
    }

    private function returnListUser()
    {
//        $listUsers = User::whereHas('roles', function ($query) {
//            $query->where('role_id', 11);
//        })->get();
        $users = null;
        $listUsers = User::where('status', UserStatus::ACTIVE)->get();
        foreach ($listUsers as $user) {
            $doctor = DoctorInfo::where('created_by', $user->id)->where('status', '!=', DoctorInfoStatus::DELETED)->first();
            if (!$doctor) {
                $users[] = $user;
            }
        }
        return collect($users);
    }
}
