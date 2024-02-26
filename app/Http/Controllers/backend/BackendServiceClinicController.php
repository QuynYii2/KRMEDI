<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;

class BackendServiceClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceClinics = ServiceClinic::paginate(20);
        return view('admin.service_of_clinic_pharmacy.index', compact('serviceClinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service_of_clinic_pharmacy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->only('name', 'name_en', 'name_laos', 'user_id');

        //kiê tra xem 1 trong name có khác null không
        if (empty($params['name']) && empty($params['name_en']) && empty($params['name_laos'])) {
            return response('Vui lòng nhập tên dịch vụ !!!', 400);
        }

        // kiểm tra xem name có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name'])) {
            $serviceClinic = ServiceClinic::where('name', $params['name'])->first();
            if ($serviceClinic) {
                return response('Tên dịch vụ đã tồn tại !!!', 400);
            }
        }
        // kiểm tra xem name_en có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name_en'])) {
            $serviceClinic = ServiceClinic::where('name_en', $params['name_en'])->first();
            if ($serviceClinic) {
                return response('Tên dịch vụ tiếng anh đã tồn tại !!!', 400);
            }
        }

        // kiểm tra xem name_laos có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name_laos'])) {
            $serviceClinic = ServiceClinic::where('name_laos', $params['name_laos'])->first();
            if ($serviceClinic) {
                return response('Tên dịch vụ tiếng laos đã tồn tại !!!', 400);
            }
        }

        $serviceClinic = new ServiceClinic();
        $serviceClinic->fill($params);

        $success = $serviceClinic->save();
        if ($success) {
            return response('Thêm dịch vụ thành công !!!', 200);
        } else {
            return response('Thêm dịch vụ thất bại !!!', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceClinic = ServiceClinic::find($id);
        return view('admin.service_of_clinic_pharmacy.edit', compact('serviceClinic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $serviceClinic = ServiceClinic::find($request->input('id'));
        $params = $request->only('name', 'name_en', 'name_laos');

        //kiê tra xem 1 trong name có khác null không
        if (empty($params['name']) && empty($params['name_en']) && empty($params['name_laos'])) {
            return response('Vui lòng nhập tên dịch vụ !!!', 400);
        }

        // kiểm tra xem name có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name'])) {
            $serviceClinicCheck = ServiceClinic::where('name', $params['name'])->first();
            if ($serviceClinicCheck && $serviceClinicCheck->id != $serviceClinic->id) {
                return response('Tên dịch vụ đã tồn tại !!!', 400);
            }
        }
        // kiểm tra xem name_en có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name_en'])) {
            $serviceClinicCheck = ServiceClinic::where('name_en', $params['name_en'])->first();
            if ($serviceClinicCheck && $serviceClinicCheck->id != $serviceClinic->id) {
                return response('Tên dịch vụ tiếng anh đã tồn tại !!!', 400);
            }
        }

        // kiểm tra xem name_laos có null không, nếu khác null thì kiểm tra đã tồn tại chưa
        if (!empty($params['name_laos'])) {
            $serviceClinicCheck = ServiceClinic::where('name_laos', $params['name_laos'])->first();
            if ($serviceClinicCheck && $serviceClinicCheck->id != $serviceClinic->id) {
                return response('Tên dịch vụ tiếng laos đã tồn tại !!!', 400);
            }
        }

        $serviceClinic->fill($params);

        $success = $serviceClinic->update();
        if ($success) {
            return response('Sửa dịch vụ thành công !!!', 200);
        } else {
            return response('Sửa dịch vụ thất bại !!!', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceClinic = ServiceClinic::find($id);
        // nếu tìm thấy, thì sửa status = Inactive và thông báo
        if ($serviceClinic) {
            $success = $serviceClinic->delete();
            if ($success) {
                return response('Xóa dịch vụ thành công !!!', 200);
            } else {
                return response('Xóa dịch vụ thất bại !!!', 400);
            }
        } else {
            return response('Không tìm thấy dịch vụ !!!', 400);
        }
    }
}
