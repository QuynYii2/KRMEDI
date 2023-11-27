<?php

namespace App\Http\Controllers;

use App\Enums\DoctorDepartmentStatus;
use App\Enums\DoctorInfoStatus;
use App\Enums\UserStatus;
use App\Models\Chat;
use App\Models\DoctorDepartment;
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
            $doctor = DoctorInfo::find($id);
            $userDoctor = User::find($doctor->created_by);
            $messageDoctor = Chat::where([
                ['from_user_id', $userDoctor->id],
                ['to_user_id', $user->id]
            ])->orWhere([
                ['to_user_id', $userDoctor->id],
                ['from_user_id', $user->id]
            ])->get();
            return view('qrCode.doctor-info', compact('messageDoctor', 'doctor'));
        }
        return redirect(route('home'));
    }

    public function create()
    {
        $departments = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)->get();
        $users = $this->returnListUser();
        $reflector = new \ReflectionClass('App\Enums\TypeMedical');
        $types = $reflector->getConstants();
        return view('admin.doctor.tab-create-doctor', compact('departments', 'users', 'types'));
    }

    private function returnListUser()
    {
//        $listUsers = User::whereHas('roles', function ($query) {
//            $query->where('role_id', 11);
//        })->get();
//        $users = null;
        $listUsers = User::where('status', UserStatus::ACTIVE)->get();
        foreach ($listUsers as $user) {
            $doctor = DoctorInfo::where('created_by', $user->id)->where('status', '!=', DoctorInfoStatus::DELETED)->first();
            if (!$doctor) {
                $users[] = $user;
            }
        }
        return collect($users);
    }

    public function edit($id)
    {
        $doctor = DoctorInfo::find($id);
        if (!$doctor) {
            return response("doctor not found", 404);
        }
        $users = $this->returnListUser();
        $departments = DoctorDepartment::where('status', DoctorDepartmentStatus::ACTIVE)->get();
        $reflector = new \ReflectionClass('App\Enums\TypeMedical');
        $types = $reflector->getConstants();
        return view('admin.doctor.tab-edit-doctor', compact('doctor', 'departments', 'users', 'types'));
    }
}
