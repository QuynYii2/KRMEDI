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
        Schema::create('family_management', function (Blueprint $table) {
            $table->id();

            $table->string('family_code')->comment('Mã hộ gia đình');
            $table->unsignedBigInteger('user_id');
            $table->string('relationship')->nullable()->comment('Quan hệ với chủ hộ');
            $table->string('name')->nullable()->comment('Họ và tên');
            $table->date('date_of_birth')->nullable()->comment('Ngày sinh');
            $table->string('number_phone')->nullable()->comment('Số điện thoại');
            $table->string('email')->nullable()->comment('Email');
            $table->string('sex')->nullable()->comment('Giới tính');
            $table->string('province_id')->nullable()->comment('Tỉnh/Thành phố');
            $table->string('district_id')->nullable()->comment('Quận/Huyện');
            $table->string('ward_id')->nullable()->comment('Phường/Xã');
            $table->string('detail_address')->nullable()->comment('Địa chỉ chi tiết');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_management');
    }
};
