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
            $table->longText('condition_en')->after('condition')->comment('Điều kiện en')->nullable();
            $table->longText('conduct_en')->after('conduct')->comment('Hướng dẫn thực hiện en')->nullable();
            $table->longText('instruction_en')->after('instruction')->comment('Hướng dẫn chi tiết en')->nullable();
            $table->longText('website_en')->after('website')->comment('Website en')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
           $table->dropColumn('condition_en');
           $table->dropColumn('conduct_en');
           $table->dropColumn('instruction_en');
           $table->dropColumn('website_en');
        });
    }
};
