<?php

use App\Enums\CouponStatus;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('title_laos')->nullable();

            $table->longText('description');
            $table->longText('description_en')->nullable();
            $table->longText('description_laos')->nullable();

            $table->longText('short_description');
            $table->longText('short_description_en')->nullable();
            $table->longText('short_description_laos')->nullable();

            $table->integer('registered');
            $table->string('views');
            $table->string('max_register');

            $table->unsignedBigInteger('user_id');

            $table->string('code');
            $table->string('status')->default(CouponStatus::INACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
