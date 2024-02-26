<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupon_applies', function (Blueprint $table) {
            $table->string('sns_option')->nullable();
            $table->string('link_')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupon_applies', function (Blueprint $table) {
            $table->dropColumn('sns_option');
            $table->dropColumn('link_');
        });
    }
};
