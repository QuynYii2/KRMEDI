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
        Schema::table('doctor_infos', function (Blueprint $table) {
            $table->string('hospital')->nullable();
            $table->string('hospital_en')->nullable();
            $table->string('hospital_laos')->nullable();

            $table->string('other')->nullable();

            $table->string('name_en')->nullable();
            $table->string('name_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_infos', function (Blueprint $table) {
            $table->dropColumn('hospital');
            $table->dropColumn('hospital_en');
            $table->dropColumn('hospital_laos');
            $table->dropColumn('other');
            $table->dropColumn('name_en');
            $table->dropColumn('name_laos');
        });
    }
};
