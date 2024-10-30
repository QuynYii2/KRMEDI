<?php

namespace App\Console;

use App\Console\Commands\DownloadRecordingVideoCall;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//        $schedule->command('download:recording')->everyMinute()->withoutOverlapping();
//        $schedule->command('voucher:check-expired')->everyMinute();
        //Remind booking schedule
//        $schedule->command('booking:check-scheduled')->hourly();

//        $schedule->command('cart:prescription-reminder')->dailyAt('12:00')->dailyAt('19:00');
        $schedule->job(new \App\Jobs\UpdateOrderStatus)->everyMinute();
        $schedule->command('appointments:remind')->everyMinute();
        $schedule->command('notification:remind')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
