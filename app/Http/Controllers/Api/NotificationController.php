<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FamilyManagement;
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
                'user_id' => 'required|numeric',
                'page' => 'nullable|numeric',
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $limit = $validatedData['limit'] ?? "";
            $user_id = $validatedData['user_id'];

            $notifications  = Notification::with('senders', 'followers')->where('follower', $user_id)->orderBy('id', 'desc');

            if ($limit) {
                $page = $validatedData['page'] ?? 1;
                $notifications = $notifications->simplePaginate($limit, ['*'], 'page', $page);
            } else {
                $notifications = $notifications->get();
            }
            foreach ($notifications as $item){
                if($item->booking_id){
                    $booking = Booking::find($item->booking_id);
                    if($booking){
                        $name_family = FamilyManagement::find($booking->member_family_id);
                        if($name_family){
                            $item->followers->name = $name_family->name??'không có dữ liệu';
                            $item->followers->birthday = $name_family->date_of_birth??'không có dữ liệu';
                            $item->followers->gender = $name_family->sex??'không có dữ liệu';
                    }

                    }
                }

            }

            $unseenNoti = Notification::where('follower', $user_id)->where('seen', 0)->count();

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
     * Seen all notifications
     */
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'user_id' => 'required|numeric'
            ]);

            if ($validated->fails()) {
                return response()->json(['error' => -1, 'message' => $validated->errors()->first()], 400);
            }

            $validatedData = $validated->validated();

            $user_id = $validatedData['user_id'];

            $notifications = Notification::where('follower', $user_id)->where('seen', 0)->get();

            foreach ($notifications as $noti) {
                $noti->seen = 1;

                $noti->save();
            }

            return response()->json(['error' => 0, 'data' => $notifications->count()]);
        } catch (\Exception $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
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
     * Update notification status unseen -> seen
     */
    public function edit($id)
    {
        try {
            if (!$id) {
                return response()->json(['error' => -1, 'message' => 'ID is required'], 400);
            }

            $notification = Notification::find($id);
            $notification->seen = 1;
            $notification->save();

            return response()->json(['error' => 0, 'data' => $notification]);
        } catch (\Exception $e) {
            return response()->json(['error' => -1, 'message' => $e->getMessage()]);
        }
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
