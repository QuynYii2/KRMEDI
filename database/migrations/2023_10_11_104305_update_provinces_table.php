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
        Schema::table('provinces', function (Blueprint $table) {
            $table->foreign('nation_id')->references('id')->on('nations');
            $table->foreign('administrative_unit_id')->references('id')->on('administrative_units');
            $table->foreign('administrative_region_id')->references('id')->on('administrative_regions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_cvs', function (Blueprint $table) {
            $table->dropForeign(['nation_id']);
            $table->dropForeign(['administrative_unit_id']);
            $table->dropForeign(['administrative_region_id']);
        });
    }
};
