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
        Schema::create('product_medicines', function (Blueprint $table) {
            $table->id();
            // name, name_en, name_laos, description, description_en, description_laos, thumbnail, gallery, object_,
            // filter_, price, user_id, category_id, brand_name, status
            $table->mediumText('name')->nullable();
            $table->mediumText('name_en')->nullable();
            $table->mediumText('name_laos')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_laos')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->longText('gallery')->nullable();
            $table->string('object_')->nullable();
            $table->string('filter_')->nullable();
            $table->string('price')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_medicines');
    }
};
