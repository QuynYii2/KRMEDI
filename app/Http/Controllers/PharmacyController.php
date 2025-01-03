<?php

namespace App\Http\Controllers;

use App\Enums\ClinicStatus;
use App\Models\Commune;
use App\Models\Department;
use App\Models\District;
use App\Models\Province;
use App\Models\ServiceClinic;
use App\Models\Symptom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    public function index()
    {
        if ($this->check_mobile()) {
            return view('pharmacy.indexMobile');
        } else {
            return view('pharmacy.index');
        }
    }

    public function searchPharmacy(Request $request)
    {
        $search_input_clinics = $request->input('search_input_clinics');
        $clinic_specialist = $request->input('clinic_specialist');
        $clinic_location = $request->input('clinic_location');
        $clinic_symptom = $request->input('clinic_symptom');

        $clinicSpecialists = explode(',', trim($request->input('mobile_clinic_specialist')));
        $clinicSymptoms = explode(',', trim($request->input('mobile_clinic_symptom')));

        $clinics = DB::table('clinics')
            ->join('users', 'users.id', '=', 'clinics.user_id')
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->where('clinics.type', \App\Enums\TypeBusiness::PHARMACIES);

        if ($search_input_clinics) {
            $clinics->where(function ($query) use ($search_input_clinics) {
                $query->where('clinics.name', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.name_en', 'LIKE', '%' . $search_input_clinics . '%')
                    ->orWhere('clinics.name_laos', 'LIKE', '%' . $search_input_clinics . '%');
            });
        }

        if ($clinic_specialist) {
            $clinics->whereRaw("FIND_IN_SET(?, clinics.department)", [$clinic_specialist]);
        }

        if ($clinic_location) {
            $clinics->where('clinics.address', 'LIKE', '%' . $clinic_location . '%')
                ->where('clinics.address', 'LIKE', '%' . $clinic_location . '%')
                ->where('clinics.address', 'LIKE', '%' . $clinic_location . '%');
        }

        if ($clinic_symptom) {
            $clinics->whereRaw("FIND_IN_SET(?, clinics.symptom)", [$clinic_symptom]);
        }

        if (!empty($clinicSpecialists) && ($clinicSpecialists[0] != "")) {
            if (!in_array('all', $clinicSpecialists)) {
                $clinics->where(function ($query) use ($clinicSpecialists) {
                    foreach ($clinicSpecialists as $specialist) {
                        $query->orWhereRaw("FIND_IN_SET(?, clinics.department)", [$specialist]);
                    }
                });
            }
        }

        if (!empty($clinicSymptoms) && ($clinicSymptoms[0] != "")) {
            if (!in_array('all', $clinicSymptoms)) {
                $clinics->where(function ($query) use ($clinicSymptoms) {
                    foreach ($clinicSymptoms as $symptom) {
                        $query->orWhereRaw("FIND_IN_SET(?, clinics.symptom)", [$symptom]);
                    }
                });
            }
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
}
