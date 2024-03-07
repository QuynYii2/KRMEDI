<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ZaloFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZaloFollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $userId = $request->userId;
            $currentUserId = $request->currentUserId;

            $currentUser = User::find($currentUserId);

            if (!$userId) {
                throw new \Exception("userId is empty");
            }

            if (!$currentUserId) {
                throw new \Exception("currentUserId is empty");
            }

            if (!$currentUser) {
                throw new \Exception("User not found");
            }

            $existedFollower = ZaloFollower::where('user_id', $userId)->first();

            $extendData = [
                'user_id' => $currentUser->id
            ];
        
            if (!$existedFollower) {
                //Create
                $existedFollower = ZaloFollower::create(
                    [
                        'user_id' => $userId,
                        'avatar' => url($currentUser->avt),
                        'name' => $currentUser->name . ' ' . $currentUser->last_name,
                        'user_id_by_app' => isset($currentUser->provider_id) && $currentUser->provider_id != null ? $currentUser->provider_id : null,
                        'phone' => $currentUser->phone ?? null,
                        'address' => $currentUser->detail_address ?? null,
                        'extend' => json_encode($extendData),
                    ]
                );
            } else {
                //Update
                $existedFollower->avatar = url($currentUser->avt);
                $existedFollower->name = $currentUser->name . ' ' . $currentUser->last_name;
                if ($currentUser->provider_id) {
                    $existedFollower->user_id_by_app = $currentUser->provider_id;
                }
                if ($currentUser->phone) {
                    $existedFollower->phone = $currentUser->phone;
                }
                if ($currentUser->detail_address) {
                    $existedFollower->address = $currentUser->detail_address;
                }
                $extendData = json_decode($existedFollower->extend, true);
                $extendData['user_id'] = $currentUser->id;
                $existedFollower->extend = json_encode($extendData);
                $existedFollower->save();
            }

            return response()->json(['error' => 0, 'user' => $existedFollower]);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        //Check user follow
        try {
            $existed = ZaloFollower::whereRaw("JSON_EXTRACT(`extend`, '$.user_id') = $user_id")->first();

            if (empty($existed)) {
                throw new \Exception("User not followed");
            }

            return response()->json(['error' => 0, 'user' => $existed]);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
