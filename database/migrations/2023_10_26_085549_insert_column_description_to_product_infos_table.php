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
        Schema::table('product_infos', function (Blueprint $table) {
            $table->string('description')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('description_en');
            $table->dropColumn('description_laos');
        });
    }
};
