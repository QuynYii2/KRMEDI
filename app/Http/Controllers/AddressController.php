<?php

namespace App\Http\Controllers;

use App\Enums\AddressStatus;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function getList()
    {
        $addresses = DB::table('addresses')
            ->where('addresses.status', '!=', AddressStatus::DELETED)
            ->where('addresses.user_id', Auth::user()->id)
            ->orderBy('addresses.id', 'desc')
            ->join('provinces', 'provinces.id', '=', 'addresses.province_id')
            ->join('districts', 'districts.id', '=', 'addresses.district_id')
            ->join('communes', 'communes.id', '=', 'addresses.commune_id')
            ->select('addresses.*',
                'provinces.full_name as provinces_name',
                'districts.full_name as districts_name',
                'communes.full_name as communes_name')
            ->get();
        return view('addresses.list', compact('addresses'));
    }

    public function detail($id)
    {
        $address = Address::find($id);
        if (!$address || $address->status == AddressStatus::DELETED) {
            alert()->error('Not found!');
            return back();
        }
        return view('addresses.detail', compact('address'));
    }

    public function create()
    {
        return view('addresses.create');
    }
}
