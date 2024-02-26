<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->longText('gallery')->change();
            $table->string('name_laos')->nullable();
            $table->string('brand_name_laos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->string('gallery');
            $table->string('name_laos');
            $table->string('brand_name_laos');
        });
    }
};
