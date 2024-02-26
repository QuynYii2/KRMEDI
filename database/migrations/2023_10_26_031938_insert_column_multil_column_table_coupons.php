<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->timestamp('startDate')->default(Carbon::now()->addHours(7));
            $table->timestamp('endDate')->default(Carbon::now()->addHours(7));
            $table->string('assign_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('startDate');
            $table->dropColumn('endDate');
            $table->dropColumn('assign_to');
        });
    }
};
