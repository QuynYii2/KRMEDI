<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class UpdateOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $orders = Order::where('status', OrderStatus::PROCESSING)
            ->where('created_at', '<=', $now->subMinutes(3))
            ->get();

        foreach ($orders as $order) {
            $order->status = OrderStatus::CANCELED;
            $order->save();
            Log::info('Order ' . $order->id . ' status updated to CANCELLED');
        }
    }
}
