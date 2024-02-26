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
        Schema::create('doctor_infos', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('thumbnail');
            $table->unsignedDouble('response_rate')->nullable()->default('100');
            $table->string('specialty')->nullable()->comment('Chuyên môn');
            $table->string('specialty_en')->nullable()->comment('Chuyên môn = tiếng anh');
            $table->integer('year_of_experience')->nullable();

            $table->string('service')->nullable()->comment('Dịch vụ cung cấp');
            $table->string('service_en')->nullable()->comment('Dịch vụ cung cấp = tiếng anh');
            $table->string('service_price')->nullable()->comment('Giá dịch vụ');
            $table->string('service_price_en')->nullable()->comment('Giá dịch vụ = tiếng anh');
            $table->string('time_working_1')->nullable()->comment('Thời gian làm việc (từ giờ nào - tới giờ nào)');
            $table->string('time_working_2')->nullable()->comment('Chọn ngày làm việc');

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
        Schema::dropIfExists('doctor_infos');
    }
};
