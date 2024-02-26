<?php

use App\Enums\DoctorReviewStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('doctor_reviews', function (Blueprint $table) {
            $table->string('title_laos')->nullable();
            $table->string('status')->default(DoctorReviewStatus::PENDING);
            $table->string('description_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_reviews', function (Blueprint $table) {
            $table->string('title_laos');
            $table->string('status');
            $table->string('description_laos');
        });
    }
};
