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
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('total_price')->change();
            $table->bigInteger('shipping_price')->change();
            $table->bigInteger('discount_price')->change();
            $table->bigInteger('total')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_price')->change();
            $table->integer('shipping_price')->change();
            $table->integer('discount_price')->change();
            $table->integer('total')->change();
        });
    }
};
