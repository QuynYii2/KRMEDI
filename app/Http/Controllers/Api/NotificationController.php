<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'limit' => 'nullable|numeric',
                'user_id' => 'required|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();
            
            $limit = $validatedData['limit'] ?? "";
            $user_id = $validatedData['user_id'];

            $notifications  = Notification::with('senders', 'followers')->where('follower', $user_id)->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc');

            if ($limit) {
                $notifications = $notifications->simplePaginate($limit);
            } else {
                $notifications = $notifications->get();
            }

            $unseenNoti = Notification::where('seen', 0)->count();

            return response()->json(['error' => 0, 'data' => $notifications, 'unseenNoti' => $unseenNoti]);
        } catch (\Exception $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
        }
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
        //
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
