<?php

namespace App\Http\Controllers;

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
            $currentUser = Auth::user();
    
            if (!$currentUser) {
                throw new \Exception("User not authenticated");
            }
    
            $zaloUser = ZaloFollower::updateOrCreate(
                ['user_id' => $userId],
                [
                    'avatar' => url($currentUser->avt),
                    'name' => $currentUser->name . ' ' . $currentUser->last_name,
                    'user_id_by_app' => isset($currentUser->provider_name) && $currentUser->provider_name == 'zalo' ? $currentUser->provider_id : null,
                    'phone' => $currentUser->phone ?? null,
                    'address' => $currentUser->detail_address ?? null,
                    'extend' => null
                ]
            );
    
            return response()->json(['error' => 0, 'user' => $zaloUser->name]);
        } catch (\Exception $e) {
            return response()->json(['error' => 1, 'message' => $e->getMessage()]);
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
