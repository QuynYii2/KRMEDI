<?php

namespace App\Providers;

use App\Http\Controllers\Api\NotificationController;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            // Resolve an instance of NotificationController
            $notificationController = app()->make(NotificationController::class);

            // Call the index() method and pass any required parameters
            $request = new Request();
            $request->merge(['limit' => 4, 'user_id' => Auth::user()->id]);

            $notifications = $notificationController->index($request);

            $notificationData = json_decode($notifications->getContent())->data ?? [];

            $unseenNoti = json_decode($notifications->getContent())->unseenNoti ?? 0;

            // Configure the data for the view
            $view->with('notifications', $notificationData->data);
            $view->with('unseenNoti', $unseenNoti);
        });

        if (Auth::check()) {
            View::composer('layouts.partials.header', function ($view) {
                // Resolve an instance of NotificationController
                $notificationController = app()->make(NotificationController::class);
    
                // Call the index() method and pass any required parameters
                $request = new Request();
                $request->merge(['limit' => 4, 'user_id' => Auth::user()->id ?? 0]);
    
                $notifications = $notificationController->index($request);
    
                $notificationData = json_decode($notifications->getContent())->data ?? [];
    
                $unseenNoti = json_decode($notifications->getContent())->unseenNoti ?? 0;
    
                // Configure the data for the view
                $view->with('notifications', $notificationData->data);
                $view->with('unseenNoti', $unseenNoti);
            });
        }
    }
}
