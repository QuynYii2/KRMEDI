<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pusher\Pusher;

class PusherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Pusher::class, function ($app) {
            return new Pusher(
                '45072ffcfd6578f7f41d', // APP_KEY
                '587cf2c904704974193e', // APP_SECRET
                '1822661',              // APP_ID
                [
                    'cluster' => 'ap1',
                    'useTLS' => true,
                ]
            );
        });
    }

    public function boot()
    {
        //
    }
}

