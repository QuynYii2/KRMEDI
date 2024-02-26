<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\Clinic;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\Province;
use App\Models\Review;
use App\Models\ServiceClinic;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessApi extends Controller
{
    public function getList(Request $request)
    {
        $type = $request->input('type');
        if ($type) {
            $items = Clinic::where('status', ClinicStatus::ACTIVE)
                ->where('type', $type)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $items = Clinic::where('status', ClinicStatus::ACTIVE)
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json($items);
    }

    public function search(Request $request)
    {
        $name = $request->input('name');

        $name = (new MainController())->vn_to_str($name);

        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->when($name, function ($query) use ($name) {
                $query->orWhere(DB::raw('LOWER(clinics.name)'), 'like', '%' . strtolower($name) . '%');
            })
            ->when($name, function ($query) use ($name) {
                $departments = Department::where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($name) . '%')->get();
                $arrayDepartmentID = $departments->pluck('id')->toArray();
                if ($arrayDepartmentID) {
                    $query->orWhereRaw("FIND_IN_SET(?, department) > 0", $arrayDepartmentID);
                }
            })
            ->when($name, function ($query) use ($name) {
                $symptoms = Symptom::where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($name) . '%')->get();
                $arraySymptomID = $symptoms->pluck('id')->toArray();
                if ($arraySymptomID) {
                    $query->orWhereRaw("FIND_IN_SET(?, symptom) > 0", $arraySymptomID);
                }
            })
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->select('clinics.*', 'users.email')
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
                /* Count and calc review*/
                $reviews = Review::where('clinic_id', $item->id)
                    ->where('status', ReviewStatus::APPROVED)
                    ->get();
                $totalReview = $reviews->count();
                $totalStar = $reviews->sum('star');
                $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;

                $clinic['total_reviews'] = $totalReview;
                $clinic['calc_reviews'] = $calcReview;
                $clinic['total_star'] = $totalStar;
                /*Show service*/
                $clinic['total_services'] = $services->count();
                $clinic['services'] = $services->toArray();
                /*Merge address*/
                if ($addressP == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }
                $addressInfo = '';
                if ($addressC) {
                    $addressInfo = $addressInfo . $addressC['name'];
                }
                if ($addressD) {
                    $addressInfo = $addressInfo . ',' . $addressD['name'];
                }
                if ($addressP) {
                    $addressInfo = $addressInfo . ',' . $addressP['name'];
                }
                $clinic['addressInfo'] = $addressInfo;
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

    public function searchByDepartmentAndSymptoms(Request $request)
    {
        $symptomID = $request->input('symptom');
        $type = $request->input('type');
        $department = $request->input('department');
        $emergency = $request->input('emergency');
        $insurance = $request->input('insurance');
        $parking = $request->input('parking');
        $information = $request->input('information');
        $facilities = $request->input('facilities');
        $equipment = $request->input('equipment');
        $costs = $request->input('costs');
        $aboutStar = $request->input('about-star');
        $workHouse = $request->input('workHouse');

        $clinics = $this->getClinics($type, $symptomID, $department, $emergency, $insurance, $parking, $information, $facilities, $equipment, $costs, $aboutStar, $workHouse);
        return response()->json($clinics);
    }

    private function getClinics($type, $symptomID, $department, $emergency, $insurance, $parking, $information, $facilities, $equipment, $costs, $aboutStar, $workHouse)
    {
        return DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->when($type, function ($query) use ($type) {
                return $query->where('clinics.type', $type);
            })
            ->when($symptomID, function ($query) use ($symptomID) {
                return $query->whereRaw("FIND_IN_SET(?, symptom) > 0", [$symptomID]);
            })
            ->when($department, function ($query) use ($department) {
                return $query->whereRaw("FIND_IN_SET(?, department) > 0", [$department]);
            })
            ->when($emergency, function ($query) use ($emergency) {
                return $query->whereRaw("FIND_IN_SET(?, emergency) > 0", [$emergency]);
            })
            ->when($insurance, function ($query) use ($insurance) {
                return $query->whereRaw("FIND_IN_SET(?, insurance) > 0", [$insurance]);
            })
            ->when($parking, function ($query) use ($parking) {
                return $query->whereRaw("FIND_IN_SET(?, parking) > 0", [$parking]);
            })
            ->when($information, function ($query) use ($information) {
                return $query->where('information', 'LIKE', '%' . $information . '%');
            })
            ->when($facilities, function ($query) use ($facilities) {
                return $query->where('facilities', 'LIKE', '%' . $facilities . '%');
            })
            ->when($equipment, function ($query) use ($equipment) {
                return $query->where('equipment', 'LIKE', '%' . $equipment . '%');
            })
            ->when(!empty($costs), function ($query) use ($costs) {
                $aboutStar = explode(',', $costs);
                return $query->whereBetween('costs', [$aboutStar[0], $aboutStar[1]]);
            })
            ->when($aboutStar, function ($query) use ($aboutStar) {
                $star = explode('-', $aboutStar);
                $query->whereBetween('clinics.average_star', [$star[0], $star[1]]);
            })
            ->when($workHouse, function ($query) use ($workHouse) {
                return $query->where('time_work', $workHouse);
            })
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->select('clinics.*', 'users.email')
            ->cursor()
            ->map(function ($item) {
                /*find usser*/
                $detailDoctor = User::where('id', $item->representative_doctor)->get();
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
                /* Count and calc review*/
                $reviews = Review::where('clinic_id', $item->id)
                    ->where('status', ReviewStatus::APPROVED)
                    ->get();
                $totalReview = $reviews->count();
                $totalStar = $reviews->sum('star');
                $calcReview = ($totalReview > 0) ? ($totalStar / $totalReview) : 0;

                $clinic['total_reviews'] = $totalReview;
                $clinic['calc_reviews'] = $calcReview;
                $clinic['total_star'] = $totalStar;
                /*Show service*/
                $clinic['total_services'] = $services->count();
                $clinic['services'] = $services->toArray();
                /*Merge address*/
                if ($addressP == null) {
                    $clinic['addressInfo'] = '';
                    return $clinic;
                }
                $addressInfo = '';
                if ($addressC) {
                    $addressInfo = $addressInfo . $addressC['name'];
                }
                if ($addressD) {
                    $addressInfo = $addressInfo . ',' . $addressD['name'];
                }
                if ($addressP) {
                    $addressInfo = $addressInfo . ',' . $addressP['name'];
                }
                $clinic['addressInfo'] = $addressInfo;
                /* Show departments*/
                $clinic['total_departments'] = $departments->count();
                $clinic['departments'] = $departments->toArray();
                /* Show symptoms*/
                $clinic['total_symptoms'] = $symptoms->count();
                $clinic['symptoms'] = $symptoms->toArray();
                $clinic['info_doctor'] = $detailDoctor->toArray();

                return $clinic;
            });
    }


    public function filter(Request $request)
    {

    }
}
