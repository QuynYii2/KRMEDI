<?php

namespace App\Http\Controllers\restapi;

use App\Enums\ClinicStatus;
use App\Enums\TypeBusiness;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\BusinessFavourite;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessFavouriteApi extends Controller
{
    public function getAll(Request $request)
    {
        $userID = $request->input('user_id');
        $business_favourites = DB::table('business_favourites')
            ->join('users', 'users.id', '=', 'business_favourites.user_id')
            ->join('clinics', 'clinics.id', '=', 'business_favourites.business_id')
            ->where('business_favourites.user_id', $userID)
            ->select('clinics.*', 'business_favourites.*')
            ->get();

        return response()->json($business_favourites);
    }

    public function getAllClinicsByUser(Request $request)
    {
        $userID = $request->input('user_id');
        $business_favourites = DB::table('business_favourites')
            ->join('users', 'users.id', '=', 'business_favourites.user_id')
            ->join('clinics', 'clinics.id', '=', 'business_favourites.business_id')
            ->where('business_favourites.user_id', $userID)
            ->select('clinics.*')
            ->get();

        return response()->json($business_favourites);
    }

    public function findByUserIdAndBusinessID(Request $request)
    {
        $userID = $request->input('user_id');
        $business_id = $request->input('business_id');

        $business_favourites = DB::table('business_favourites')
            ->join('users', 'users.id', '=', 'business_favourites.user_id')
            ->join('clinics', 'clinics.id', '=', 'business_favourites.business_id')
            ->where('business_favourites.user_id', $userID)
            ->where('business_favourites.business_id', $business_id)
            ->where('clinics.status', ClinicStatus::ACTIVE)
            ->select('business_favourites.*')
            ->get();

        return response()->json($business_favourites);
    }

    public function create(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $business_id = $request->input('business_id');
            $type = $request->input('type');
            if (!$type) {
                $type = TypeBusiness::CLINICS;
            }

            if (!$userID || !$business_id) {
                return response('User or Business not empty', 404);
            }

            $user = User::find($userID);
            if (!$user || $user->status != UserStatus::ACTIVE) {
                return response('User not found', 404);
            }

            $business = Clinic::find($business_id);
            if (!$business) {
                return response('Business not found', 404);
            }

            $exit = BusinessFavourite::where('user_id', $userID)->where('business_id', $business_id)->first();
            if ($exit) {
                return response('Favorite business has been created', 400);
            }

            $business_favourite = new BusinessFavourite();
            $business_favourite->user_id = $userID;
            $business_favourite->business_id = $business_id;
            $business_favourite->type = $type;

            $success = $business_favourite->save();
            if ($success) {
                return response()->json($business_favourite);
            }
            return response('Adding favorite business encountered an error', 400);
        } catch (\Exception $exception) {
            return response($exception, 400);
        }
    }

    public function delete($id)
    {
        $business_favourite = BusinessFavourite::find($id);
        if ($business_favourite) {
            $success = BusinessFavourite::where('id', $id)->delete();
            if ($success) {
                return response('Delete success', 200);
            }
            return response('Delete error', 400);
        }
        return response('Not found', 404);
    }
}
