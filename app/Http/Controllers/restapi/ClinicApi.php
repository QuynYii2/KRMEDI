<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\DepartmentStatus;
use App\Enums\ReviewStatus;
use App\Enums\TypeBusiness;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\Province;
use App\Models\Review;
use App\Models\ServiceClinic;
use App\Models\Symptom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicApi extends Controller
{
    public function getAll()
    {
        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', TypeBusiness::CLINICS)
            ->select('clinics.*', 'users.email')
            ->cursor()
            ->map(function ($item) {
                $array = explode(',', $item->service_id);
                $services = ServiceClinic::whereIn('id', $array)->get();
                $array = explode(',', $item->address);
                $addressP = Province::where('id', $array[1] ?? null)->first();
                $addressD = District::where('id', $array[2] ?? null)->first();
                $addressC = Commune::where('id', $array[3] ?? null)->first();
                $clinic = (array)$item;

                $reviews = Review::where('clinic_id', $item->id)
                    ->where('status', ReviewStatus::APPROVED)
                    ->get();
                $totalReview = $reviews->count();
                $totalStar = $reviews->sum('star');
                $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;

                $clinic['total_reviews'] = $totalReview;
                $clinic['calc_reviews'] = $calcReview;
                $clinic['total_star'] = $totalStar;

                $clinic['total_services'] = $services->count();
                $clinic['services'] = $services->toArray();
                if ($addressC == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }
                if ($addressD == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }
                if ($addressP == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }

                $clinic['addressInfo'] = $addressC['full_name'] . ',' . $addressD['full_name'] . ',' . $addressP['full_name'];
                return $clinic;
            });

        return response()->json($clinics);
    }

    public function searchByDepartmentAndSymptoms(Request $request)
    {
        $symptomID = $request->input('symptom');
        $department = $request->input('department');

        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', TypeBusiness::CLINICS);

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
                /* Count review*/
                $reviews = Review::where('clinic_id', $item->id)
                    ->where('status', ReviewStatus::APPROVED)
                    ->get();
                $totalReview = $reviews->count();
                $totalStar = $reviews->sum('star');
                $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;

                $clinic['total_reviews'] = $totalReview;
                $clinic['total_star'] = $totalStar;
                $clinic['calc_reviews'] = $calcReview;
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

    public function searchClinics(Request $request)
    {
        $search_input_clinics = $request->input('search_input_clinics');
        $clinic_specialist = $request->input('clinic_specialist');
        $clinic_location = $request->input('clinic_location');

        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE);

        if ($search_input_clinics) {
            $clinics->where(function ($query) use ($search_input_clinics) {
                $query->where('clinics.name', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.name_en', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.name_laos', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.phone', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.email', 'LIKE', '%' . $search_input_clinics . '%');
            });
        }

        if ($clinic_specialist) {
            $clinics->where('clinics.representative_doctor', $clinic_specialist);
        }

        if ($clinic_location) {
            $clinics->where('clinics.address', 'LIKE', '%' . $clinic_location . '%')
                ->where('clinics.address', 'LIKE', '%' . $clinic_location . '%')
                ->where('clinics.address', 'LIKE', '%' . $clinic_location . '%');
        }

        $clinics = $clinics->select('clinics.*', 'users.email')
            ->cursor()
            ->map(function ($item) {
                /* Find services */
                $services = $this->findRelatedItems(ServiceClinic::class, $item->service_id);
                /* Find address */
                $addressInfo = $this->getAddressInfo($item->address);
                /* Find departments */
                $departments = $this->findRelatedItems(Department::class, $item->department);
                /* Find symptoms */
                $symptoms = $this->findRelatedItems(Symptom::class, $item->symptom);
                /* Convert to array */
                $clinic = (array)$item;
                /* Show services */
                $clinic['total_services'] = $services->count();
                $clinic['services'] = $services->toArray();
                /* Merge address */
                $clinic['addressInfo'] = $addressInfo;
                /* Merge address */
                $clinic['open_date'] = Carbon::parse($item->open_date)->format('Y-m-d H:i:s');
                $clinic['close_date'] = Carbon::parse($item->close_date)->format('Y-m-d H:i:s');
                /* Show departments */
                $clinic['total_departments'] = $departments->count();
                $clinic['departments'] = $departments->toArray();
                /* Show symptoms */
                $clinic['total_symptoms'] = $symptoms->count();
                $clinic['symptoms'] = $symptoms->toArray();
                return $clinic;
            });

        return response()->json($clinics);
    }

    private function findRelatedItems($modelClass, $ids)
    {
        $list_ids = explode(',', $ids);
        return $modelClass::whereIn('id', $list_ids)->get();
    }

    private function getAddressInfo($address)
    {
        $array = explode(',', $address);
        $addressP = Province::find($array[1] ?? null);
        $addressD = District::find($array[2] ?? null);
        $addressC = Commune::find($array[3] ?? null);

        if ($addressC == null || $addressD == null || $addressP == null) {
            return '';
        }

        return $addressC['name'] . ',' . $addressD['name'] . ',' . $addressP['name'];
    }

    public function detail($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic || $clinic->status != ClinicStatus::ACTIVE) {
            return response("Clinic not found", 404);
        }
        $user = User::find($clinic->user_id);
        $response = $clinic->toArray();

        $list_department = $clinic->department;
        $array_department = explode(',', $list_department);
        $departments = Department::whereIn('id', $array_department)
            ->where('status', DepartmentStatus::ACTIVE)
            ->get();

        $response['email'] = $user->email;
        $response['departments'] = $departments;
        return response()->json($response);
    }

    public function getAllByUserId($id)
    {
        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', TypeBusiness::CLINICS)
            ->where('clinics.user_id', $id)
            ->select('clinics.*', 'users.email')
            ->get();
        return response()->json($clinics);
    }


    /* Helper function to find related items */

    public function getAllSpecialist()
    {
        $representatives = DB::table('clinics')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->join('users', 'users.id', '=', 'clinics.representative_doctor')
            ->distinct()
            ->select('clinics.representative_doctor', 'users.name')
            ->get();
        $representatives = $representatives->toArray();
        return array_filter($representatives);
    }

    /* Helper function to get address information */

    public function getAllLocation()
    {
        $provinces = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->join('provinces', 'provinces.id', '=', 'users.province_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->select('provinces.*',)
            ->distinct()
            ->get();
        return response()->json($provinces);
    }
}
