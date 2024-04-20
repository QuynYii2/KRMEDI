<?php

namespace App\Jobs;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\restapi\MainApi;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBooking implements ShouldQueue
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
     * Execute the job.
     */
    public function handle(): void
    {
        $newBooking = $this->booking;

        $bookingController = new BookingController();
        $bookingController->sendMessageToUserOnBookingCreated($newBooking);
        // $bookingController->sendOAMessageFromAdminToClinic($newBooking);

        // Send Noti
        $mainApi = new MainApi();
        $newRequestData = [
            'id' => $newBooking->id,
            'user_id' => $newBooking->user_id,
            'clinic_id' => $newBooking->clinic_id,
        ];
        $request = new Request($newRequestData);
        $mainApi->sendFcmNotification($request);
    }
}
