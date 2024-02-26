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
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialty')->nullable()->comment('Chuyên môn');
            $table->string('specialty_en')->nullable()->comment('Chuyên môn = tiếng anh');
            $table->string('specialty_laos')->nullable()->comment('Chuyên môn = tiếng lào');
            $table->integer('year_of_experience')->nullable();

            $table->longText('service')->nullable()->comment('Dịch vụ cung cấp');
            $table->longText('service_en')->nullable()->comment('Dịch vụ cung cấp = tiếng anh');
            $table->longText('service_laos')->nullable()->comment('Dịch vụ cung cấp = tiếng lào');
            $table->string('service_price')->nullable()->comment('Giá dịch vụ');
            $table->string('service_price_en')->nullable()->comment('Giá dịch vụ = tiếng anh');
            $table->string('service_price_laos')->nullable()->comment('Giá dịch vụ = tiếng lào');
            $table->string('time_working_1')->nullable()->comment('Thời gian làm việc (từ giờ nào - tới giờ nào)');
            $table->string('time_working_2')->nullable()->comment('Chọn ngày làm việc');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('apply_for')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('specialty');
            $table->dropColumn('specialty_en');
            $table->dropColumn('specialty_laos');
            $table->dropColumn('year_of_experience');

            $table->dropColumn('service');
            $table->dropColumn('service_en');
            $table->dropColumn('service_laos');
            $table->dropColumn('service_price');
            $table->dropColumn('service_price_en');
            $table->dropColumn('service_price_laos');
            $table->dropColumn('time_working_1');
            $table->dropColumn('time_working_2');

            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');

            $table->dropColumn('department_id');
            $table->dropColumn('apply_for');
        });
    }
};
