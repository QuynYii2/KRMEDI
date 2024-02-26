<?php

namespace App\Http\Controllers;

use Pusher\Pusher;

class AlertNotificationController extends Controller
{
    public function pushNoti()
    {
        $data = \App\Models\AlertNotification::create([
            'link' => '123',
            'message' => '$request->receiver_id',
            'from_user_id' => auth()->user()->id,
            'to_user_id' => '137'
        ]);


        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

//        $PUSHER_APP_KEY = '3ac4f810445d089829e8';
//        $PUSHER_APP_KEY = 'e700f994f98dbb41ea9f';
//        $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
//        $PUSHER_APP_ID = '1714303';

//        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);


//        $pusher = new Pusher(
//            env('PUSHER_APP_KEY', '3ac4f810445d089829e8'),
//            env('PUSHER_APP_SECRET', 'c6cafb046a45494f80b2'),
//            env('PUSHER_APP_ID', '1714303'),
//            $options
//        );

        $PUSHER_APP_KEY = '3ac4f810445d089829e8';
        $PUSHER_APP_SECRET = 'c6cafb046a45494f80b2';
        $PUSHER_APP_ID = '1714303';

        $pusher = new Pusher($PUSHER_APP_KEY, $PUSHER_APP_SECRET, $PUSHER_APP_ID, $options);


        $pusher->trigger('AlertNotification', 'AlertNotification', $data);

        broadcast(new \App\Events\AlertNotification($data));

        return response()->json([
            'message' => 'Push notification sent successfully!'
        ]);
    }
}
