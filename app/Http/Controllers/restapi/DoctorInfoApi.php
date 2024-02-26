<?php

namespace App\Http\Controllers\restapi;

use App\Enums\DoctorInfoStatus;
use App\Enums\TypeMedical;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\Booking;
use App\Models\Chat;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\DoctorInfo;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorInfoApi extends Controller
{
    public function getAll(Request $request)
    {
        $size = $request->input('size');
        if ($size && $size > 0 && is_numeric($size)) {
            $doctorInfos = User::where('status', UserStatus::ACTIVE)->orderBy('id', 'DESC')
                ->where('member', TypeMedical::DOCTORS)
                ->limit($size)->get();
        } else {
            $doctorInfos = User::where('status', UserStatus::ACTIVE)->orderBy('id', 'DESC')
                ->where('member', TypeMedical::DOCTORS)
                ->get();
        }
        return response()->json($doctorInfos);
    }

    public function getDoctor24h(Request $request)
    {
        $size = $request->input('size');
        if ($size && $size > 0 && is_numeric($size)) {
            $Doctor24hInfos = User::where('time_working_1', '==', '00:00-23:59')
                ->where('time_working_2', '==', 'T2-CN')
                ->where('status', UserStatus::ACTIVE)
                ->where('member', TypeMedical::DOCTORS)
                ->limit($size)->get();
        } else {
            $Doctor24hInfos = User::where('time_working_1', '==', '00:00-23:59')
                ->where('time_working_2', '==', 'T2-CN')
                ->where('status', UserStatus::ACTIVE)
                ->where('member', TypeMedical::DOCTORS)->get();
        }
        return response()->json($Doctor24hInfos);
    }

    public function searchDoctor(Request $request)
    {
        $keyword = $request->input('name');
        $name = (new MainController())->vn_to_str($keyword);

        $listDoctor = $this->findDoctor($name, null, null, null, null);

        return response()->json($listDoctor);
    }

    private function findDoctor($name, $department, $province, $hospital, $experience)
    {
        $listDoctor = User::where('member', TypeMedical::DOCTORS)
            ->where('status', UserStatus::ACTIVE)
            ->when($name, function ($query) use ($name) {
                $query->where(DB::raw('LOWER(users.name)'), 'like', '%' . strtolower($name) . '%');
            })
            ->when($department, function ($query) use ($department) {
                $query->where('users.department_id', $department);
            })
            ->when($province, function ($query) use ($province) {
                $query->where('users.province_id', $province);
            })
            ->when($hospital, function ($query) use ($hospital) {
                $query->join('clinics', 'clinics.user_id', '=', 'users.id')
                    ->where('clinics.id', $hospital);
            })
            ->when($experience, function ($query) use ($experience) {
                $query->where('users.year_of_experience', $experience);
            })
            ->when($name, function ($query) use ($name) {
                $departments = Department::where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($name) . '%')->get();
                $arrayDepartmentID = $departments->pluck('id')->toArray();
                if ($arrayDepartmentID) {
                    $query->orWhereRaw("FIND_IN_SET(?, department_id) > 0", $arrayDepartmentID);
                }
            })
            ->when($name, function ($query) use ($name) {
                $symptoms = Symptom::where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($name) . '%')->get();
                $arraySymptomID = $symptoms->pluck('id')->toArray();
                if ($arraySymptomID) {
                    $query->orWhereRaw("FIND_IN_SET(?, symptom_id) > 0", $arraySymptomID);
                }
            })
            ->orderBy('id', 'desc')
            ->get();
        return $listDoctor;
    }

    public function findByUser($id)
    {
        $doctor_info = DoctorInfo::where('created_by', $id)
            ->where('hocham_hocvi', TypeMedical::DOCTORS)
            ->first();
        if (!$doctor_info || $doctor_info->status != DoctorInfoStatus::ACTIVE) {
            return response('Not found', 404);
        }
        return response()->json($doctor_info);
    }

    public function findByDepartment($id, Request $request)
    {
        $size = $request->input('size');
        if ($size && $size > 0 && is_numeric($size)) {
            $doctor_infos = User::where('department_id', $id)
                ->where('member', TypeMedical::DOCTORS)
                ->orderBy('id', 'DESC')
                ->limit($size)
                ->get();
        } else {
            $doctor_infos = User::where('department_id', $id)
                ->where('member', TypeMedical::DOCTORS)
                ->orderBy('id', 'DESC')
                ->get();
        }
        return response()->json($doctor_infos);
    }

    public function detail(Request $request, $id)
    {
        $doctor_infos = User::where('id', $id)
            ->where('member', TypeMedical::DOCTORS)
            ->first();
        if (!$doctor_infos || $doctor_infos->status != UserStatus::ACTIVE) {
            return response('Not found', 404);
        }
        return response()->json($doctor_infos);
    }

    public function getMyDoctor($id)
    {
        $arrUserIds = [];

        // lấy danh sách user đã từng chat với user hiện tại
        $listWasChat = Chat::where('from_user_id', $id)
            ->orWhere('to_user_id', $id)
            ->select('to_user_id', 'from_user_id')
            ->get();

        foreach ($listWasChat as $chat) {
            array_push($arrUserIds, $chat->to_user_id);
            array_push($arrUserIds, $chat->from_user_id);
        }

        // lấy danh sách user đã từng đặt lịch khám với user hiện tại
        $listWasBookingClinic = Booking::where('user_id', $id)
            ->select('clinic_id')
            ->get();

        foreach ($listWasBookingClinic as $clinic) {
            $user_id = Clinic::where('id', $clinic->clinic_id)->first()->user_id;
            array_push($arrUserIds, $user_id);
        }


        /*
         * cần bổ sung lấy danh sách các bác sỹ từng follow
        */

        // tạo mảng chứa các giá trị duy nhất
        $arrUserIds = array_unique($arrUserIds);

        // xóa id của user hiện tại khỏi mảng
        $arrUserIds = array_diff($arrUserIds, [$id]);

        $listUser = User::whereIn('id', $arrUserIds)
            ->where('member', TypeMedical::DOCTORS)
            ->where('status', UserStatus::ACTIVE)
            ->cursor()
            ->map(function ($user) use (&$mapUserNames) {
                $user->name = User::getNameByID($user->id);
                return $user;
            });


        return response()->json($listUser);
    }

    public function findDoctorByKeyword(Request $request)
    {
        $keyword = $request->input('keyword');

        $department = $request->input('department_id');
        $province = $request->input('province_id');
        $hospital = $request->input('hospital_id');
        $experience = $request->input('year_of_experience');

        $name = (new MainController())->vn_to_str($keyword);

        $listDoctor = $this->findDoctor($name, $department, $province, $hospital, $experience);
        $html = null;

        foreach ($listDoctor as $pharmacist) {
            $html .= $this->loadHtmlFormDoctor($pharmacist);
        }

        $title = __('home.no data');

        if (!$html) {
            $html = '<h3 class="no-data text-center">' . $title . '</h3>';
        }

        return $html;
    }

    private function loadHtmlFormDoctor($pharmacist)
    {
        return view('examination.component_doctor_findmymedicine', compact('pharmacist'));
    }

    public function getAllDoctorByClinic(Request $request)
    {
        $clinic_id = $request->input('clinic_id');

        $clinic = Clinic::find($clinic_id);
        if (!$clinic) {
            return response((new MainApi())->returnMessage('Not found'), 400);
        }

        $list_doctor_id = $clinic->representative_doctor;
        $array_doctor = explode(',', $list_doctor_id);

        $doctorInfos = DB::table('users')->where('status', UserStatus::ACTIVE)
            ->where('users.member', TypeMedical::DOCTORS)
            ->whereIn('users.id', $array_doctor)
            ->orderBy('users.id', 'DESC')
            ->get();

        return response()->json($doctorInfos);
    }

    public function getDoctorByDepartmentIDAndClinicID(Request $request)
    {
        $department_id = $request->input('department_id');
        $clinic_id = $request->input('clinic_id');

        $clinic = Clinic::find($clinic_id);
        if (!$clinic) {
            return response((new MainApi())->returnMessage('Not found'), 400);
        }

        $list_doctor_id = $clinic->representative_doctor;
        $array_doctor = explode(',', $list_doctor_id);

        $doctorInfos = DB::table('users')->where('status', UserStatus::ACTIVE)
            ->where('users.member', TypeMedical::DOCTORS)
            ->where('users.department_id', $department_id)
            ->whereIn('users.id', $array_doctor)
            ->orderBy('users.id', 'DESC')
            ->get();
        return response()->json($doctorInfos);
    }
}
