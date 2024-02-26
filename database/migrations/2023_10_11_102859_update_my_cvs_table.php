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
        Schema::table('my_cvs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('education_id')->references('id')->on('cv_education');
            $table->foreign('skill_id')->references('id')->on('cv_skills');
            $table->foreign('certificate_id')->references('id')->on('cv_certificates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_cvs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['education_id']);
            $table->dropForeign(['skill_id']);
            $table->dropForeign(['certificate_id']);
        });
    }
};
