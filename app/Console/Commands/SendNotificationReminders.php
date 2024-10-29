<?php

namespace App\Console\Commands;

use App\Models\PrescriptionResults;
use App\Models\User;
use App\Services\FcmService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotificationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông báo nhắc nhở uống thuốc';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $listData = PrescriptionResults::all();
        $currentHour = Carbon::now()->format('H');
        $currentDate = Carbon::now()->toDateString();

        if (count($listData)>0){
            foreach ($listData as $item) {
                $user = User::find($item->user_id);
                if ($user->is_send == 1){
                    $prescriptions = json_decode($item->prescriptions, true);
                    if (is_array($prescriptions)){
                        foreach ($prescriptions as $prescription) {
                            if (isset($prescription['date_start'], $prescription['date_end'])) {
                                if ($currentDate >= $prescription['date_start'] && $currentDate <= $prescription['date_end']) {
                                    if (isset($prescription['note_date']) && is_array($prescription['note_date'])) {
                                        foreach ($prescription['note_date'] as $note) {
                                            if (($note == 1 && $currentHour == 7) ||
                                                ($note == 2 && $currentHour == 8) ||
                                                ($note == 3 && $currentHour == 11) ||
                                                ($note == 4 && $currentHour == 12) ||
                                                ($note == 5 && $currentHour == 7) ||
                                                ($note == 6 && $currentHour == 8)) {
                                                if ($user && $user->token_firebase) {
                                                    $notificationPayload = [
                                                        'title' => 'Thông báo sắp đến giờ uống thuốc',
                                                        'body' => 'Bạn có một lịch uống thuốc sắp diễn ra.',
                                                    ];

                                                    $data = [
                                                        'title' => "Thông báo sắp đến giờ uống thuốc",
                                                        'sender' => "",
                                                        'url' => "#",
                                                        'description' => "Bạn có một lịch uống thuốc sắp diễn ra.",
                                                        'id' => '1',
                                                        'routeKey'=>'/',
                                                        'arguments'=>json_encode($item),
                                                    ];

                                                    $androidPayload = [
                                                        'notification' => [
                                                            'icon' => 'ic_launcher',
                                                            'channel_id' => 'booking_channel_id',
                                                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                                                            'sound' => 'default',
                                                        ],
                                                    ];

                                                    $iosPayload = [
                                                        'aps' => [
                                                            'sound' => 'default',
                                                            'badge' => 1,
                                                        ],
                                                    ];

                                                    $payload = [
                                                        'token' => $user->token_firebase,
                                                        'notification' => $notificationPayload,
                                                        'data' => array_merge($data, [
                                                            'channel_id' => 'booking_channel_id',
                                                        ]),
                                                    ];

                                                    $platform = $notification->platform ?? 'ANDROID';

                                                    if ($platform === 'ANDROID') {
                                                        $payload['android'] = $androidPayload;
                                                    } elseif ($platform === 'IOS') {
                                                        $payload['apns'] = ['payload' => $iosPayload];
                                                    }

                                                    $response = FcmService::init()->request($payload);
                                                    $responseBody = json_decode($response, true);

                                                    if (isset($responseBody['name'])) {
                                                        // Success
                                                        $this->info("Notification sent successfully to user {$user->name} (User ID: {$user->id}).");
                                                    } else {
                                                        $this->error("Failed to send notification to user {$user->name} (User ID: {$user->id}).");
                                                    }
                                                }else{
                                                    $this->error("User not found");
                                                }
                                            }else{
                                                $this->error("No data");
                                            }
                                        }
                                    }else{
                                        $this->error("No data");
                                    }
                                }else{
                                    $this->error("No data");
                                }
                            }else{
                                $this->error("No data");
                            }
                        }
                    }
                }else{
                    $this->error("User not send");
                }
            }
        }else{
            $this->error("No data");
        }
    }
}
