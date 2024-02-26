<?php

use App\Enums\AnswerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('content_en');
            $table->string('content_laos');
            $table->integer('question_id')->nullable();
            $table->unsignedBigInteger('answer_parent');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default(AnswerStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
