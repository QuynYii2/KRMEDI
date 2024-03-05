<?php

use App\Enums\online_medicine\ShapeProduct;
use App\Enums\online_medicine\UnitQuantityProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_medicines', function (Blueprint $table) {
            $table->string('shape')
                ->default(ShapeProduct::OTHER)
                ->nullable()
                ->comment('Hình dạng của thuốc');
            $table->string('unit_quanity')
                ->default(UnitQuantityProduct::OTHER)
                ->nullable()
                ->comment('Đơn vị tính toán');
            $table->string('manufacturing_country')->comment('Nguồn gốc sản suất')->nullable();
            $table->string('manufacturing_company')->comment('Công ty sản suất')->nullable();
            $table->string('specifications')->comment('Quy cách đóng gói')->nullable();
            $table->string('short_description')->nullable();
            $table->string('short_description_en')->nullable();
            $table->string('short_description_laos')->nullable();
            $table->string('number_register')->nullable()->comment('Số đăng ký');
            $table->string('side_effects')->comment('Tác dụng phụ')->nullable();
            $table->string('uses')->comment('Công dụng')->nullable();
            $table->string('user_manual')->comment('Hướng dẫn sử dụng')->nullable();
            $table->string('notes')->comment('Lưu ý')->nullable();
            $table->string('preserve')->comment('Bảo quản')->nullable();
            $table->unsignedBigInteger('proved_by')->default(4)->comment('Người duyệt thuốc');
            $table->foreign('proved_by')->references(/**/'id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_medicines', function (Blueprint $table) {
            $table->dropColumn('shape');
            $table->dropColumn('unit_quanity');
            $table->dropColumn('manufacturing_country');
            $table->dropColumn('manufacturing_company');
            $table->dropColumn('specifications');
            $table->dropColumn('short_description');
            $table->dropColumn('short_description_en');
            $table->dropColumn('short_description_laos');
            $table->dropColumn('number_register');
            $table->dropColumn('side_effects');
            $table->dropColumn('uses');
            $table->dropColumn('user_manual');
            $table->dropColumn('notes');
            $table->dropColumn('preserve');
            $table->dropColumn('proved_by');
        });
    }
};
