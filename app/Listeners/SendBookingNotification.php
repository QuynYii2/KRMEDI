<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Http\Controllers\BookingController;
use App\Models\Booking;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public $booking;

    public function __construct()
    {
        $this->booking = new BookingController();
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        // Xử lý sự kiện khi có bản ghi booking mới được tạo
        // Sử dụng $event->booking để truy cập bản ghi booking mới
        $newBooking = $event->booking;
        // Eager load the clinic and user relationships
        $newBooking->load('clinic.users', 'user', 'doctor');

        //Gửi tin nhắn cho người dùng bằng OA Bệnh viện
        $this->booking->sendMessageToUserOnBookingCreated($newBooking);
        //Gửi tin nhắn từ OA tổng cho OA Bệnh viện
        $this->booking->sendOAMessageFromAdminToClinic($newBooking);
    }
}
