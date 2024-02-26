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
        Schema::table('prescription_results', function (Blueprint $table) {
            $table->boolean('isFirstBuy')->nullable()->default(false)->comment('Đã mua lần dầu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_results', function (Blueprint $table) {
            $table->dropColumn('isFirstBuy');
        });
    }
};
