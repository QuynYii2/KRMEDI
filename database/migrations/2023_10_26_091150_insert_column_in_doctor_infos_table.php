<?php

use App\Enums\DoctorInfoStatus;
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
        Schema::table('doctor_infos', function (Blueprint $table) {
            $table->string('service_laos');
            $table->string('specialty_laos');
            $table->string('service_price_laos');
            $table->string('detail_address_en');
            $table->string('detail_address_laos');
            $table->string('status')->default(DoctorInfoStatus::ACTIVE);
            $table->string('apply_for');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_infos', function (Blueprint $table) {
            $table->dropColumn('specialty_laos');
            $table->dropColumn('service_price_laos');
            $table->dropColumn('detail_address_en');
            $table->dropColumn('detail_address_laos');
            $table->dropColumn('status');
            $table->dropColumn('apply_for');
        });
    }
};
