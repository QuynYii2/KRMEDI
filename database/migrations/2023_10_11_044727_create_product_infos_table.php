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
        Schema::create('product_infos', function (Blueprint $table) {
            $table->id();

            $table->mediumText('name');
            $table->mediumText('name_en')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('brand_name')->nullable()->comment('Tên thương hiệu');
            $table->string('brand_name_en')->nullable()->comment('Tên thương hiệu');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->longText('thumbnail');
            $table->string('gallery')->nullable();
            $table->integer('price');
            $table->string('price_unit')->nullable()->comment('Đơn vị tiền tệ');
            $table->integer('ads_plan')->comment('Cấp quảng cáo');
            $table->integer('ads_period')->comment('Thời gian Quảng cáo');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_infos');
    }
};
