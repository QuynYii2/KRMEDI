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
        Schema::table('users', function (Blueprint $table) {
            $table->string('health_insurance_back')->nullable();
            $table->string('health_insurance_front')->nullable();
            $table->date('date_health_insurance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['health_insurance_back']);
            $table->dropColumn(['health_insurance_front']);
            $table->dropColumn(['date_health_insurance']);
        });
    }
};
