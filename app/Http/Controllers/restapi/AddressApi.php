<?php

namespace App\Http\Controllers\restapi;

use App\Enums\AddressStatus;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressApi extends Controller
{
    public function getListByUserID($id)
    {
        $addresses = DB::table('addresses')
            ->where('addresses.status', '!=', AddressStatus::DELETED)
            ->where('addresses.user_id', $id)
            ->orderBy('addresses.id', 'desc')
            ->join('provinces', 'provinces.id', '=', 'addresses.province_id')
            ->join('districts', 'districts.id', '=', 'addresses.district_id')
            ->join('communes', 'communes.id', '=', 'addresses.commune_id')
            ->select('addresses.*',
                'provinces.full_name as provinces_name',
                'districts.full_name as districts_name',
                'communes.full_name as communes_name')
            ->get();
        return response()->json($addresses);
    }

    public function create(Request $request)
    {
        try {
            $address = new Address();

            $address = $this->save($request, $address);
            $success = $address->save();
            if ($success) {
                return response()->json($address);
            }
            return response((new MainApi())->returnMessage('Create error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function save($request, $address)
    {
        $username = $request->input('username');
        $phone = $request->input('phone');
        $province_id = $request->input('province_id');
        $district_id = $request->input('district_id');
        $commune_id = $request->input('commune_id');
        $address_detail = $request->input('address_detail');
        $user_id = $request->input('user_id');
        $is_default = $request->input('is_default');
        if ($is_default == null) {
            $is_default = 0;
        } else {
            $is_default = 1;
            Address::where('user_id', $user_id)
                ->where('status', AddressStatus::ACTIVE)
                ->where('is_default', 1)
                ->update(['is_default' => 0]);
        }
        $status = $request->input('status') ?? AddressStatus::ACTIVE;

        $address->username = $username;
        $address->phone = $phone;
        $address->province_id = $province_id;
        $address->district_id = $district_id;
        $address->commune_id = $commune_id;
        $address->address_detail = $address_detail;
        $address->user_id = $user_id;
        $address->is_default = $is_default;
        $address->status = $status;

        return $address;
    }

    public function update($id, Request $request)
    {
        try {
            $address = Address::find($id);
            if (!$address || $address->status == AddressStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 404);
            }
            $address = $this->save($request, $address);
            $success = $address->save();
            if ($success) {
                return response()->json($address);
            }
            return response((new MainApi())->returnMessage('Update error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }

    public function detail($id)
    {
        $address = Address::find($id);
        if (!$address || $address->status == AddressStatus::DELETED) {
            return response((new MainApi())->returnMessage('Not found!'), 404);
        }
        return response()->json($address);
    }

    public function getAddressDefault(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        if (!$user || $user->status == UserStatus::DELETED) {
            return response((new MainApi())->returnMessage('User not found!'), 404);
        }
        $address = Address::where('user_id', $user->id)
            ->where('is_default', 1)
            ->first();

        if (!$address) {
            $address = Address::where('user_id', $user->id)
                ->first();
        }

        if (!$address) {
            return response((new MainApi())->returnMessage('User not created!'), 404);
        }

        $province = Province::find($address->province_id);
        $district = District::find($address->district_id);
        $address = $address->toArray();
        $address['province'] = $province ? $province->name : '';
        $address['district'] = $district ? $district->name : '';
        return response()->json($address);
    }

    public function delete($id)
    {
        try {
            $address = Address::find($id);
            if (!$address || $address->status == AddressStatus::DELETED) {
                return response((new MainApi())->returnMessage('Not found!'), 404);
            }

            $address->status = AddressStatus::DELETED;
            $success = $address->save();
            if ($success) {
                return response((new MainApi())->returnMessage('Delete success!'), 200);
            }
            return response((new MainApi())->returnMessage('Delete error!'), 400);
        } catch (\Exception $exception) {
            return response((new MainApi())->returnMessage('Error, Please try again!'), 400);
        }
    }
}
