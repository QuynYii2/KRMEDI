<?php

namespace App\Http\Controllers\backend;

use App\Enums\ServiceClinicStatus;
use App\Http\Controllers\Controller;
use App\Models\ServiceClinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendServiceHospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = ServiceClinic::where('user_id', Auth::id())
            ->where('status', '!=', ServiceClinicStatus::DELETED)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.service_hospital.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service_hospital.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_price' => 'nullable|numeric',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);
        try {
            ServiceClinic::create([
                'name' => $request->name,
                'service_price' => $request->service_price,
                'status' => $request->status,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('api.serviceHospital.index')->with('success', 'Tạo dịch vụ thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('home.Failed to create service: ') . $e->getMessage());
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
        $service = ServiceClinic::find($id);
        if (!$service || $service->status == ServiceClinicStatus::DELETED) {
            return back()->with('error', 'Không tìm thấy dịch vụ');
        }
        return view('admin.service_hospital.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_price' => 'nullable|numeric',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        try {
            $service = ServiceClinic::find($id);
            if (!$service || $service->status == ServiceClinicStatus::DELETED) {
                return back()->with('error', 'Không tìm thấy dịch vụ');
            }

            $service->update([
                'name' => $request->name,
                'service_price' => $request->service_price,
                'status' => $request->status,
            ]);

            return redirect()->route('api.serviceHospital.index')->with('success', 'Cập nhật dịch vụ thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('home.Failed to update service: ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $service = ServiceClinic::find($id);
            if (!$service || $service->status == ServiceClinicStatus::DELETED) {
                return back()->with('error', 'Không tìm thấy dịch vụ');
            }
            $service->status = ServiceClinicStatus::DELETED;
            $success = $service->save();
            if ($success) {
                return back()->with('success', 'Xóa dịch vụ thành công');
            }
            return back()->with('error', 'Xóa dịch vụ thất bại');
        } catch (\Exception $exception) {
            return back()->with('error', 'Xóa dịch vụ thất bại: ' . $exception->getMessage());
        }
    }
}
