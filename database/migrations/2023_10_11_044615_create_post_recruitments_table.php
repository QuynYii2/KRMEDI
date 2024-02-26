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
        Schema::create('post_recruitments', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Tiêu đề công việc');
            $table->string('title_en')->comment('Tiêu đề công việc = tiếng anh')->nullable();
            $table->string('position')->comment('Chức vụ');
            $table->string('position_en')->comment('Chức vụ = tiếng anh')->nullable();
            $table->string('type_employment')->comment('Loại nhân viên (Thời vụ/ Full-time/ Part-time)');
            $table->string('type_experience')->comment('Loại kinh nghiệm (Không yêu cầu/ không cần kinh nghiệm/ cần kinh nghiệm)');
            $table->integer('year_of_experience')->nullable()->comment('Số năm kinh nghiệm');
            $table->string('type_of_experience')->nullable()->default('YEAR')->comment('Loại kinh nghiệm (Năm/ tháng)');
            $table->integer('salary')->comment('Mức lương');
            $table->string('salary_type')->comment('Loại lương (Theo tháng/ theo năm)');
            $table->string('salary_unit')->default('VND')->comment('Đơn vị tiền tệ');

            $table->text('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('commune_id')->nullable();
            $table->string('detail_address')->nullable();

            $table->string('application_method')->comment('Phương thức ứng tuyển');
            $table->date('application_deadline')->comment('Hạn ứng tuyển');

            $table->string('status_post')->nullable()->default('1')->comment('Trạng thái bài viết');
            $table->unsignedBigInteger('company_id')->comment('ID công ty');

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
        Schema::dropIfExists('post_recruitments');
    }
};
