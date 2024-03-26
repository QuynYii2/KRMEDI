<?php

namespace App\Console\Commands;

use App\Http\Controllers\restapi\BookingApi;
use Illuminate\Console\Command;

class BookingScheduleReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Booking schedule before checkin time an hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $booking = new BookingApi();
        $booking->bookingReminder();
    }
}
