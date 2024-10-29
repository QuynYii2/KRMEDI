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
        Schema::table('product_medicines', function (Blueprint $table) {
            $table->longText('short_description')->nullable()->change();
            $table->longText('short_description_en')->nullable()->change();
            $table->longText('short_description_laos')->nullable()->change();
            $table->longText('uses')->nullable()->change();
            $table->longText('user_manual')->nullable()->change();
            $table->longText('notes')->nullable()->change();
            $table->longText('preserve')->nullable()->change();
            $table->longText('side_effects')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_medicines', function (Blueprint $table) {
            $table->string('short_description', 255)->nullable(false)->change();
            $table->string('short_description_en', 255)->nullable(false)->change();
            $table->string('short_description_laos', 255)->nullable(false)->change();
            $table->string('uses', 255)->nullable(false)->change();
            $table->string('user_manual', 255)->nullable(false)->change();
            $table->string('notes', 255)->nullable(false)->change();
            $table->string('preserve', 255)->nullable(false)->change();
            $table->string('side_effects', 255)->nullable(false)->change();
        });
    }
};
