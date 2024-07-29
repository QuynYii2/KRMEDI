<?php

namespace App\Http\Controllers\ui;

use App\Enums\PrescriptionResultStatus;
use App\Enums\TypeProductCart;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DrugIngredients;
use App\Models\online_medicine\ProductMedicine;
use App\Models\PrescriptionResults;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrescriptionResultController extends Controller
{
    public function create(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $listMedicine = ProductMedicine::where('quantity', '>', 0)->get();

        return view('ui.prescription-results.create', compact('user', 'listMedicine'));
    }

    public function myPrescription(Request $request)
    {
        $searchTerm = $request->input('search', '');

        // Fetch the prescriptions with pagination and searching
        $listPrescriptions = Cart::with('doctors')
            ->select(['id', 'prescription_id', 'created_at', 'status', 'doctor_id'])
            ->where('user_id', Auth::user()->id)
            ->where('type_product', TypeProductCart::MEDICINE)
            ->whereNotNull('prescription_id')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where(function($query) use ($searchTerm) {
                    $query->whereHas('doctors', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    })
                        ->orWhere('prescription_id', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get(['id', 'prescription_id', 'created_at', 'status', 'doctor_id'])
            ->groupBy('prescription_id')
            ->map(fn ($group) => $group->first())
            ->values();

        $prescriptionIds = $listPrescriptions->pluck('prescription_id')->toArray();

        $prescriptions = [];

        foreach ($prescriptionIds as $prescriptionId) {
            $data = Cart::with('productMedicine')->where('prescription_id', $prescriptionId)->get();
            $prescriptions[] = [
                'prescription_id' => $prescriptionId,
                'data' => $data
            ];
        }

        $listPrescriptions = $this->paginateCustom($listPrescriptions, 25, $request->input('page'), ['path' => $request->url(), 'query' => $request->query()]);

        return view('ui.prescription-results.my-prescriptions')->with(compact('listPrescriptions', 'prescriptions'));
    }

    private function paginateCustom($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function doctorPrescription()
    {
        return view('ui.prescription-results.doctor-prescriptions');
    }

    public function getListMedicine(Request $request)
    {
        $name_search = $request->input('name_search');
        $drug_ingredient_search = $request->input('drug_ingredient_search');
        $object_search = $request->input('object_search');
        $clinic_search = $request->input('clinic_search');

        $clinicQuery = DB::table('clinics as c1')
            ->select('c1.user_id', DB::raw('MIN(c1.id) as min_id'))
            ->groupBy('c1.user_id');
        $listMedicine = ProductMedicine::where('quantity', '>', 0)
            ->leftJoinSub($clinicQuery, 'first_clinic', function ($join) {
                $join->on('product_medicines.user_id', '=', 'first_clinic.user_id');
            })
            ->leftJoin('clinics as c2', 'first_clinic.min_id', '=', 'c2.id')
            ->leftJoin('users', 'product_medicines.user_id', '=', 'users.id')
            ->select(
                'product_medicines.*',
                'c2.latitude',
                'c2.longitude',
                'users.detail_address as detail_address'
        );

        if ($drug_ingredient_search) {
            $listMedicineId = DrugIngredients::where('component_name', 'like', '%' . $drug_ingredient_search . '%')->pluck('product_id');
            $listMedicine = $listMedicine->whereIn('id', $listMedicineId);
        }

        if ($name_search) {
            $listMedicine = $listMedicine->where('product_medicines.name', 'like', '%' . $name_search . '%');
        }

        if ($object_search) {
            $listMedicine = $listMedicine->where('object_', $object_search);
        }

        if ($clinic_search) {
            $listMedicine = $listMedicine->where('users.name', 'like', '%' . $clinic_search . '%');
        }

        $listMedicine = $listMedicine->get();
        return response()->json($listMedicine);
    }

    public function detail($id)
    {
        $prescription = PrescriptionResults::find($id);
        if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
            alert()->warning('Not found result!');
            return back();
        }

        $value_result = $prescription->prescriptions;
        $array_result = json_decode($value_result, true);

        return view('ui.prescription-results.detail', compact('array_result', 'prescription'));
    }

    public function detailApi($id)
    {
        $prescription = PrescriptionResults::find($id);
        if (!$prescription || $prescription->status == PrescriptionResultStatus::DELETED) {
            return response()->json(['status' => false]);
        }

        $value_result = '[' . $prescription->prescriptions . ']';
        $array_result = json_decode($value_result, true);
        return response()->json(['status' => true, 'listData' => $array_result, 'prescription' => $prescription]);
    }
}
