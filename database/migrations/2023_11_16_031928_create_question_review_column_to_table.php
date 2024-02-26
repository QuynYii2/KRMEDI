<?php

use App\Enums\ReviewStoreStatus;
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
        Schema::create('review_stores', function (Blueprint $table) {
            $table->id();
            $table->longText('content')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_laos')->nullable();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_laos')->nullable();
            $table->integer('star_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('store_id');
            $table->string('status')->default(ReviewStoreStatus::PENDING);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_stores');
    }
};
