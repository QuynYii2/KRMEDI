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
        Schema::table('new_events', function (Blueprint $table) {
            $table->longText('short_description')->nullable();
            $table->longText('short_description_en')->nullable();
            $table->longText('short_description_laos')->nullable();
            $table->longText('title')->nullable();
            $table->longText('title_en')->nullable();
            $table->longText('title_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_events', function (Blueprint $table) {
            //
        });
    }
};
