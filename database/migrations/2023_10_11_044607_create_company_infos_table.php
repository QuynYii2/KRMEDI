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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Tên công ty');
            $table->string('name_en')->comment('Tên công ty = tiếng anh')->nullable();
            $table->mediumText('short_description')->comment('Mô tả ngắn')->nullable();
            $table->mediumText('short_description_en')->comment('Mô tả ngắn = tiếng anh')->nullable();
            $table->longText('full_description')->comment('Mô tả chi tiết')->nullable();
            $table->longText('full_description_en')->comment('Mô tả chi tiết = tiếng anh')->nullable();
            $table->integer('number_staff')->comment('Số nhân viên')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('incorporation_date')->comment('Ngày thành lập công ty')->nullable();
            $table->string('speciality')->comment('Lĩnh vực/ chuyên môn')->nullable();
            $table->string('speciality_en')->comment('Lĩnh vực/ chuyên môn = tiếng anh')->nullable();

            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('commune_id')->nullable();
            $table->string('detail_address')->nullable();

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
        Schema::dropIfExists('company_infos');
    }
};
