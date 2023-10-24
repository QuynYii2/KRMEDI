<?php

namespace App\Http\Controllers;

use App\Enums\ClinicStatus;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{

    public function index()
    {
        return view('clinics.listClinics');
    }
    public function show($id)
    {
        $clinics = Clinic::find($id);
        if (!$clinics || $clinics->status != ClinicStatus::ACTIVE) {
            return response("Product not found", 404);
        }
        return response()->json($clinics);
    }

    public function detail()
    {
        return view('clinics.detailClinics');
    }

    public function create()
    {
        return view('admin.tab-create-clinics');
    }

    public function edit()
    {
        return view('admin.tab-edit-clinics');
    }
}
