<?php

use App\Enums\OrderMethod;
use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->integer('full_name');
            $table->integer('email');
            $table->integer('phone');
            $table->integer('address');

            $table->integer('total_price')->comment('Giá toàn bộ sản phẩm');
            $table->integer('shipping_price')->comment('Giá tiền phí vận chuyển');
            $table->integer('discount_price')->comment('Giá tiền giảm giá');
            $table->integer('total')->comment('Tổng tiền thanh toán');

            $table->string('order_method')->default(OrderMethod::IMMEDIATE);
            $table->string('status')->default(OrderStatus::WAIT_PAYMENT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
