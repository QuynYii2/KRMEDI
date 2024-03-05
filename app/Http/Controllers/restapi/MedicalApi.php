<?php

namespace App\Http\Controllers\restapi;

use App\Enums\TypeMedical;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalApi extends Controller
{
    public function searchByDepartmentAndSymptoms(Request $request)
    {
        $symptomID = $request->input('symptom');
        $type = $request->input('type');
        $department = $request->input('department');
        $medicals = $this->getMedical($type, $symptomID, $department);
        return response()->json($medicals);
    }

    private function getMedical($type, $symptomID, $department)
    {
        if (!$type) {
            $type = TypeMedical::DOCTORS;
        }
        $listDoctor = User::where('member', $type)
            ->where('status', UserStatus::ACTIVE)
            ->when($symptomID, function ($query) use ($symptomID) {
                return $query->whereRaw("FIND_IN_SET(?, symptom_id) > 0", [$symptomID]);
            })
            ->when($department, function ($query) use ($department) {
                return $query->whereRaw("FIND_IN_SET(?, department_id) > 0", [$department]);
            })
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($listDoctor);
    }

    public function searchMedical(Request $request)
    {
        $star = $request->input('star');

        $fullTime = $request->input('fulltime');
        $experience = $request->input('experience');
        $type = $request->input('type');
        $free = $request->input('free');
        $prescription = $request->input('prescription');
        $medicals = $this->processSearchMedical($type, $star, $experience, $free, $prescription);
        return response()->json($medicals);
    }

    private function processSearchMedical($type, $star, $experience, $prescription, $free)
    {
        if (!$type) {
            $type = TypeMedical::DOCTORS;
        }

        $query = User::where('member', $type)
            ->where('status', UserStatus::ACTIVE);

        if ($prescription !== null) {
            $query->where('prescription', $prescription);
        }

        if ($free !== null) {
            $query->where('free', $free);
        }

        if ($experience) {
            $aboutYear = explode('-', $experience);
            $query->whereBetween('year_of_experience', [$aboutYear[0], $aboutYear[1]]);
        }

        if ($star) {
            $aboutStar = explode('-', $star);
            $query->whereBetween('average_star', [$aboutStar[0], $aboutStar[1]]);
        }

        $result = $query->orderByDesc('id')->get();
        return $result;
    }
}
