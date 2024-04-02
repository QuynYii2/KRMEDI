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
        Schema::create('aha_orders', function (Blueprint $table) {
            $table->id();
            $table->string('_id')->unique();
            $table->string('supplier_id')->nullable();
            $table->text('shared_link')->nullable();
            $table->longText('path');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aha_orders');
    }
};
