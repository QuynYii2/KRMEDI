<?php

namespace App\Console\Commands;

use App\Http\Controllers\connect\CallVideoController;
use Illuminate\Console\Command;

class DownloadRecordingVideoCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:recording';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $downloadRecord = new CallVideoController();
        $downloadRecord->handleDownloadRecordByRoomName();
    }
}
