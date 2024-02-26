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
        Schema::table('symptoms', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('name_laos')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symptoms', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('name_laos');
            $table->dropColumn('description_en');
            $table->dropColumn('description_laos');
        });
    }
};
