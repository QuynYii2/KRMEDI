<?php

namespace App\Http\Controllers\restapi;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\online_medicine\ProductMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineApi extends Controller
{
    public function getAllByClinic(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'clinic_id' => 'required|numeric',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $clinicId = $validatedData['clinic_id'];

            $clinic = Clinic::findOrFail($clinicId);
            $firstUser = $clinic->users()->first();
            if ($firstUser) {
                $medicines = $firstUser->productMedicines()->with('category')->where('status', 'APPROVED')->get();
            }


            return response()->json(['error' => 0, 'medicines' => $medicines, 'clinic' => $clinic]);
        } catch (\Exception $e) {
            return response(['error' => -1, 'message' => $e->getMessage()], 400);
        }
    }
}
