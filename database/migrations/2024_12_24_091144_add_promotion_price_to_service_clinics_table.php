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
        Schema::table('service_clinics', function (Blueprint $table) {
            $table->string('service_price_promotion')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_clinics', function (Blueprint $table) {
            $table->dropColumn('service_price_promotion');
            $table->dropColumn('date_start');
            $table->dropColumn('date_end');
        });
    }
};
