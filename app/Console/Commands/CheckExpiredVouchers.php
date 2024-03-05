<?php

namespace App\Console\Commands;

use App\Enums\CouponStatus;
use App\Models\Coupon;
use Illuminate\Console\Command;

class CheckExpiredVouchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-vouchers';

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
        $expiredVouchers = Coupon::where('endDate', '<', now())->get();
        foreach ($expiredVouchers as $voucher) {
            $voucher->status = CouponStatus::DELETED;
            $voucher->save();
        }
    }
}
