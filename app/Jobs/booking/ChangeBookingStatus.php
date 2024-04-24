<?php

namespace App\Jobs\booking;

use App\Http\Controllers\restapi\MainApi;
use App\Http\Controllers\ZaloController;
use App\Models\User;
use App\Models\ZaloFollower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChangeBookingStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    /**
     * Create a new job instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }


    /**
     * Execute the job. (Notification when user change )
     */
    public function handle(): void
    {
        try {
            $booking = $this->booking;

            $userId = $booking->user_id;
            $userFollower = ZaloFollower::where('extend->user_id', $userId)->first();
            $admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'ADMIN');
            })
                ->whereNotNull('extend->access_token_zalo')
                ->first();
            $adminAccessToken = $admin->extend['access_token_zalo'];
            $additionalParams = [
                'user_id' => $userFollower->user_id,
                'booking_clinic' => $booking->clinic->name,
                'booking_clinic_id' => $booking->clinic_id,
                'user_name' => $booking->user->name . ' ' . $booking->user->last_name,
                'booking_status' => $booking->status,
                'booking_cancel_reason' => $booking->reason_cancel,
                'booking_clinic_checkin' => date('d/m/Y h:i A', strtotime($booking->check_in))
            ];
            $request = new Request();
            $newRequest = $request->duplicate()->merge($additionalParams);
            $zalo = new ZaloController($adminAccessToken);
            $checkStatus = $zalo->sendBookingMessage($newRequest);

            if (isset($checkStatus['error']) && $checkStatus['error'] == 1) {
                $zalo->sendBookingMessage($newRequest);
            }

            //Send notification
            $mainApi = new MainApi();
            $newRequestData = [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'clinic_id' => $booking->clinic_id,
                'user_title' => 'Trạng thái booking đã thay đổi',
                'clinic_title' => 'Thay đổi trạng thái booking thành công',
            ];
            $request = new Request($newRequestData);
            $mainApi->sendFcmNotification($request);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error send booking result: ' . $e->getMessage());
        }
    }
}
