<?php

namespace App\Http\Controllers;

use App\Imports\ServiceClinicImport;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceClinicController extends Controller
{
    public function getListService()
    {
        return view('admin.service-clinics.list-service-clinics');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ServiceClinicImport, $request->file('file'));
            dd(123);
            return redirect()->back()->with('success', 'Dữ liệu đã được import thành công!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
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
