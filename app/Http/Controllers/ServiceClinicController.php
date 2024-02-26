<?php

namespace App\Http\Controllers;

use App\Models\ServiceClinic;

class ServiceClinicController extends Controller
{
    public function getListService()
    {
        return view('admin.service-clinics.list-service-clinics');
    }

    public function detailService($id)
    {
        $service = ServiceClinic::find($id);
        return view('admin.service-clinics.detail-service-clinics', compact('service'));
    }

    public function createService()
    {
        return view('admin.service-clinics.create-service-clinics');
    }
}
