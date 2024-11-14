<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\User;
use App\Services\FcmService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông báo nhắc nhở lịch khám cho người dùng';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $upcomingAppointments = Booking::where('check_in', '=', Carbon::now()->addHours(2)->startOfMinute())->where('status','APPROVED')->get();

        if (count($upcomingAppointments)>0){
            foreach ($upcomingAppointments as $appointment) {
                $user = User::find($appointment->user_id);
                if ($user && $user->token_firebase) {
                    $notificationPayload = [
                        'title' => 'Thông báo sắp đến giờ khám',
                        'body' => 'Bạn có một lịch khám sắp diễn ra.',
                    ];

                    $data = [
                        'title' => "Thông báo sắp đến giờ khám",
                        'sender' => "",
                        'url' => "#",
                        'description' => "Bạn có một lịch khám sắp diễn ra.",
                        'id' => '1',
                        'routeKey'=>'/booking-user',
                        'arguments'=>json_encode($appointment->id),
                    ];

                    $androidPayload = [
                        'notification' => [
                            'icon' => 'ic_launcher',
                            'channel_id' => 'default_channel_id',
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
                            'channel_id' => 'default_channel_id',
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
                        // Failure
                        $this->error("Failed to send notification to user {$user->name} (User ID: {$user->id}).");
                    }
                }else{
                    $this->error("User not found");
                }
            }
        }else{
            $this->error("No data");
        }

    }
}
