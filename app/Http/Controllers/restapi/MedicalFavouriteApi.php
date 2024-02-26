<?php

namespace App\Http\Controllers\restapi;

use App\Enums\TypeMedical;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\MedicalFavourite;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalFavouriteApi extends Controller
{
    public function getAll(Request $request)
    {
        $userID = $request->input('user_id');
        $medical_favourites = DB::table('medical_favourites')
            ->join('users', 'users.id', '=', 'medical_favourites.medical_id')
            ->where('medical_favourites.user_id', $userID)
            ->select('medical_favourites.*', 'users.name')
            ->cursor()
            ->map(function ($item) {
                $user = User::find($item->medical_id);
                /* Convert to array */
                $medical_favourite = (array)$item;
                $medical_favourite['doctor_info'] = $user;
                return $medical_favourite;
            });

        return response()->json($medical_favourites);
    }

    public function findByUserIdAndMedicalID(Request $request)
    {
        $userID = $request->input('user_id');
        $medical_id = $request->input('medical_id');

        $medical_favourites = DB::table('medical_favourites')->join('users', 'users.id', '=',
            'medical_favourites.user_id')->where('medical_favourites.user_id',
            $userID)->where('medical_favourites.medical_id', $medical_id)->where('users.status',
            UserStatus::ACTIVE)->select('medical_favourites.*')->cursor()->map(function ($item) {
            $user = User::find($item->medical_id);
            /* Convert to array*/
            $medical_favourite = (array)$item;
            $medical_favourite['doctor_info'] = $user;
            return $medical_favourite;
        });

        return response()->json($medical_favourites);
    }

    public function create(Request $request)
    {
        try {
            $userID = $request->input('user_id');
            $medical_id = $request->input('medical_id');
            $type = $request->input('type');
            if (!$type) {
                $type = TypeMedical::DOCTORS;
            }

            if (!$userID || !$medical_id) {
                return response((new MainApi())->returnMessage('User or Medical not empty'), 404);
            }

            $user = User::find($userID);
            if (!$user || $user->status != UserStatus::ACTIVE) {
                return response((new MainApi())->returnMessage('User not found'), 404);
            }

            $medical = User::find($medical_id);
            if (!$medical) {
                return response((new MainApi())->returnMessage('Medical not found'), 404);
            }

            $exit = MedicalFavourite::where('user_id', $userID)->where('medical_id', $medical_id)->first();
            if ($exit) {
                return response((new MainApi())->returnMessage('Favorite medical has been created'), 400);
            }

            $medical_favourite = new MedicalFavourite();
            $medical_favourite->user_id = $userID;
            $medical_favourite->medical_id = $medical_id;
            $medical_favourite->type = $type;

            $success = $medical_favourite->save();
            if ($success) {
                return response()->json($medical_favourite);
            }
            return response((new MainApi())->returnMessage('Adding favorite medical encountered an error'), 400);
        } catch (Exception $exception) {
            return response($exception, 400);
        }
    }

    public function updateWishListMedical(Request $request)
    {
        $userID = $request->input('user_id');
        $medical_id = $request->input('medical_id');
        $medical_type = $request->input('medical_type');

        if (!$medical_type) {
            $medical_type = TypeMedical::DOCTORS;
        }

        $mediFavourite = MedicalFavourite::where([
            ['user_id', $userID],
            ['medical_id', $medical_id],
            ['type', $medical_type]
        ])->first();

        if (!$mediFavourite) {
            $mediFavourite = new MedicalFavourite();
            $mediFavourite->user_id = $userID;
            $mediFavourite->medical_id = $medical_id;
            $mediFavourite->type = $medical_type;

            $success = $mediFavourite->save();
            if ($success) {
                return response()->json([
                    'status' => true,
                    'isFavourite' => true,
                    'message' => 'Add to wishlist success'
                ]);
            }
        } else {
            $success = MedicalFavourite::where([
                ['user_id', $userID],
                ['medical_id', $medical_id],
                ['type', $medical_type]
            ])->delete();
            if ($success) {
                return response()->json([
                    'status' => true,
                    'isFavourite' => false,
                    'message' => 'Remove from wishlist success'
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Add to wishlist error'
        ]);
    }

    public function delete($id)
    {
        $medical_favourite = MedicalFavourite::find($id);
        if ($medical_favourite) {
            $success = MedicalFavourite::where('id', $id)->delete();
            if ($success) {
                return response('Delete success', 200);
            }
            return response('Delete error', 400);
        }
        return response('Not found', 404);
    }
}
