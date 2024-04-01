<?php

namespace App\Console\Commands;

use App\Http\Controllers\restapi\CartApi;
use Illuminate\Console\Command;

class CartPrescriptionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:prescription-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cart reminder in 7AM and 7PM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cart = new CartApi();
        $cart->prescriptionReminder();
    }
}
