<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ClinicLocation;
use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendClinicLocationController extends Controller
{
    public function index($userID)
    {
        $addresses = ClinicLocation::where('user_id', $userID)
            ->join('provinces', 'clinic_locations.province_id', '=', 'provinces.code')
            ->join('districts', 'clinic_locations.district_id', '=', 'districts.code')
            ->join('communes', 'clinic_locations.commune_id', '=', 'communes.code')
            ->select('clinic_locations.*', 'provinces.name as province_name', 'districts.name as district_name', 'communes.name as commune_name')
            ->get();

        return view('admin.clinic_location.index', compact('addresses', 'userID'));
    }

    public function create($userID)
    {
        return view('admin.clinic_location.create', compact('userID'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'province_id' => 'required',
                'district_id' => 'required',
                'commune_id' => 'required',
                'detail_address' => 'required|string|max:255',
                'status' => 'required|in:Active,Inactive',
            ]);

            $clinicLocation = new ClinicLocation();

            $newLatitude = $request->input('new_latitude');
            $newLongitude = $request->input('new_longitude');

            $clinicLocation->user_id = $request->input('user_id');
            $clinicLocation->province_id = $request->input('province_id');
            $clinicLocation->district_id = $request->input('district_id');
            $clinicLocation->commune_id = $request->input('commune_id');
            $clinicLocation->address_detail = $request->input('detail_address');
            $clinicLocation->latitude = $newLatitude;
            $clinicLocation->longitude = $newLongitude;
            $clinicLocation->status = $request->input('status');

            $clinicLocation->save();

            return redirect()->route('api.clinic-location.index', $request->input('user_id'))->with('success', 'Cập nhật địa chỉ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Vui lòng chọn đủ thông tin.')->withInput();
        }
    }

    public function edit($userID, $id)
    {
        $address = ClinicLocation::find($id);

        $province = Province::all();
        $district = District::where('province_code',$address->province_id)->get();
        $commune = Commune::where('district_code',$address->district_id)->get();

        return view('admin.clinic_location.edit', compact('address', 'province', 'district', 'commune', 'userID'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'province_id' => 'required',
                'district_id' => 'required',
                'commune_id' => 'required',
                'detail_address' => 'required|string|max:255',
                'status' => 'required|in:Active,Inactive',
            ]);

            $clinicLocation = ClinicLocation::findOrFail($id);

            $newLatitude = $request->input('new_latitude') ?? $clinicLocation->latitude;
            $newLongitude = $request->input('new_longitude') ?? $clinicLocation->longitude;

            $clinicLocation->province_id = $request->input('province_id');
            $clinicLocation->district_id = $request->input('district_id');
            $clinicLocation->commune_id = $request->input('commune_id');
            $clinicLocation->address_detail = $request->input('detail_address');
            $clinicLocation->latitude = $newLatitude;
            $clinicLocation->longitude = $newLongitude;
            $clinicLocation->status = $request->input('status');

            $clinicLocation->save();

            return redirect()->route('api.clinic-location.index', $request->input('user_id'))->with('success', 'Cập nhật địa chỉ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Vui lòng chọn đủ thông tin.')->withInput();
        }
    }
    public function destroy(string $id)
    {
        try {
            $address = ClinicLocation::find($id);
            if (!$address) {
                return back()->with('error', 'Không tìm thấy địa chỉ');
            }
            $success = $address->delete();
            if ($success) {
                return back()->with('success', 'Xóa địa chỉ thành công');
            }
            return back()->with('error', 'Xóa địa chỉ thất bại');
        } catch (\Exception $exception) {
            return back()->with('error', 'Xóa địa chỉ thất bại: ' . $exception->getMessage());
        }
    }
}
