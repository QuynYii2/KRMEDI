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
        Schema::table('family_management', function (Blueprint $table) {
            $table->string('insurance_id')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('health_insurance_back')->nullable();
            $table->string('health_insurance_front')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_management', function (Blueprint $table) {
            $table->dropColumn(['insurance_id']);
            $table->dropColumn(['insurance_date']);
            $table->dropColumn(['health_insurance_back']);
            $table->dropColumn(['health_insurance_front']);
        });
    }
};
