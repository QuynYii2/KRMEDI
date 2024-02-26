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
            $table->dropColumn('short_description');
            $table->dropColumn('short_description_en');
            $table->dropColumn('short_description_laos');
            $table->dropColumn('title');
            $table->dropColumn('title_en');
            $table->dropColumn('title_laos');
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
