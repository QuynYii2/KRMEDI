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
        Schema::table('coupons', function (Blueprint $table) {
            $table->timestamp('startDate')->nullable()->comment('Thời gian bắt đầu ứng tuyển')->change();
            $table->timestamp('endDate')->nullable()->comment('Thời gian kết thúc ứng tuyển')->change();
            $table->timestamp('start_selective')->nullable()->comment('Thời gian bắt đầu chọn lọc');
            $table->timestamp('end_selective')->nullable()->comment('Thời gian kết thúc chọn lọc');
            $table->timestamp('start_post')->nullable()->comment('Thời gian bắt đầu đăng bài');
            $table->timestamp('end_post')->nullable()->comment('Thời gian kết thúc đăng bài');
            $table->timestamp('start_evaluate')->nullable()->comment('Thời gian bắt đầu đánh giá');
            $table->timestamp('end_evaluate')->nullable()->comment('Thời gian kết thúc đánh giá');
            $table->longText('short_description')->nullable()->comment('Phần thưởng')->change();
            $table->longText('condition')->nullable()->comment('Điều kiện');
            $table->longText('conduct')->nullable()->comment('Hướng dẫn thực hiện');
            $table->longText('description')->nullable()->comment('Yêu cầu')->change();
            $table->boolean('is_tiktok')->default(0)->comment('Có phải coupon tiktok không');
            $table->boolean('is_instagram')->default(0)->comment('Có phải coupon instagram không');
            $table->boolean('is_youtube')->default(0)->comment('Có phải coupon youtube không');
            $table->boolean('is_google')->default(0)->comment('Có phải coupon google không');
            $table->boolean('is_facebook')->default(0)->comment('Có phải coupon facebook không');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('start_selective');
            $table->dropColumn('end_selective');
            $table->dropColumn('start_post');
            $table->dropColumn('end_post');
            $table->dropColumn('start_evaluate');
            $table->dropColumn('end_evaluate');
            $table->dropColumn('condition');
            $table->dropColumn('conduct');
            $table->dropColumn('is_tiktok');
            $table->dropColumn('is_instagram');
            $table->dropColumn('is_youtube');
            $table->dropColumn('is_google');
            $table->dropColumn('is_facebook');
        });
    }
};
