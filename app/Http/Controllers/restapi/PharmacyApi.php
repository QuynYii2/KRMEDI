<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\TypeBusiness;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\Province;
use App\Models\ServiceClinic;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyApi extends Controller
{
    public function getAll()
    {
        $pharmacies = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', TypeBusiness::PHARMACIES)
            ->select('clinics.*', 'users.email')
            ->get();
        return response()->json($pharmacies);
    }

    public function detail($id)
    {
        $pharmacy = Clinic::find($id);
        if (!$pharmacy || $pharmacy->status != ClinicStatus::ACTIVE) {
            return response("Pharmacy not found", 404);
        }
        $user = User::find($pharmacy->user_id);
        $response = $pharmacy->toArray();
        $response['email'] = $user->email;
        return response()->json($response);
    }

    public function searchByDepartmentAndSymptoms(Request $request)
    {
        $department = $request->input('department');
        $symptomID = $request->input('symptom');

        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.type', TypeBusiness::PHARMACIES)
            ->where('clinics.status', ClinicStatus::ACTIVE);

        if ($symptomID && $department) {
            $clinics->whereRaw("FIND_IN_SET(?, department) > 0", [$department])
                ->whereRaw("FIND_IN_SET(?, symptom) > 0", [$symptomID]);
        } else {
            $clinics->where(function ($query) use ($symptomID, $department) {
                $query->whereRaw("FIND_IN_SET(?, symptom) > 0", [$symptomID])
                    ->orWhereRaw("FIND_IN_SET(?, department) > 0", [$department]);
            });
        }

        $clinics = $clinics->select('clinics.*', 'users.email')
            ->cursor()
            ->map(function ($item) {
                /*Find service*/
                $array = explode(',', $item->service_id);
                $services = ServiceClinic::whereIn('id', $array)->get();
                /*Find Address*/
                $array = explode(',', $item->address);
                $addressP = Province::where('id', $array[1] ?? null)->first();
                $addressD = District::where('id', $array[2] ?? null)->first();
                $addressC = Commune::where('id', $array[3] ?? null)->first();
                /*Find department*/
                $list_departments = explode(',', $item->department);
                $departments = Department::whereIn('id', $list_departments)->get();
                /*Find symptom*/
                $list_symptoms = explode(',', $item->symptom);
                $symptoms = Symptom::whereIn('id', $list_symptoms)->get();
                /* Convert to array*/
                $clinic = (array)$item;
                /*Show service*/
                $clinic['total_services'] = $services->count();
                $clinic['services'] = $services->toArray();
                /*Merge address*/
                if ($addressP == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }
                $clinic['addressInfo'] = $addressC['name'] . ',' . $addressD['name'] . ',' . $addressP['name'];
                /* Show departments*/
                $clinic['total_departments'] = $departments->count();
                $clinic['departments'] = $departments->toArray();
                /* Show symptoms*/
                $clinic['total_symptoms'] = $symptoms->count();
                $clinic['symptoms'] = $symptoms->toArray();
                return $clinic;
            });

        return response()->json($clinics);
    }

    public function getAllByUserId($id)
    {
        $pharmacies = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', TypeBusiness::PHARMACIES)
            ->where('clinics.user_id', $id)
            ->select('clinics.*', 'users.email')
            ->get();
        return response()->json($pharmacies);
    }
}
