<?php

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
            $table->dropColumn('unit_quanity');
            $table->string('unit_quantity')
                ->default(UnitQuantityProduct::OTHER)
                ->nullable()
                ->comment('Đơn vị tính toán');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_medicines', function (Blueprint $table) {
            $table->dropColumn('unit_quantity');
        });
    }
};
