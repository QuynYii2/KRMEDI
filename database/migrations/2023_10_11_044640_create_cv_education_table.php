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
        Schema::create('cv_education', function (Blueprint $table) {
            $table->id();

            $table->string('specialize')->comment('Chuyên ngành đào tạo');
            $table->string('specialize_en')->comment('Chuyên ngành đào tạo = tiếng anh')->nullable();
            $table->string('school')->comment('(Tên trung tâm/ trường đại học)');
            $table->string('school_en')->comment('(Tên trung tâm/ trường đại học) = tiếng anh')->nullable();
            $table->string('degree')->comment('Loại bằng cấp');
            $table->string('degree_en')->comment('Loại bằng cấp = tiếng anh')->nullable();
            $table->string('from_month')->comment('Từ tháng nào');
            $table->string('to_month')->nullable()->comment('Đến tháng nào');
            $table->string('is_graduate')->comment('Đã tốt nghiệp/ Chưa tốt nghiệp');
            $table->string('description')->nullable();

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
        Schema::dropIfExists('cv_education');
    }
};
