<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answer_likes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('answer_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_like')->default(false);

            $table->foreign('answer_id')->references('id')->on('answers');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_likes');
    }
};
