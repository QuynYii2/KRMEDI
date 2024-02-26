<?php

use App\Enums\SurveyStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->longText('question');
            $table->longText('question_en');
            $table->longText('question_laos');

            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_laos')->nullable();

            $table->longText('answer');
            $table->longText('answer_en');
            $table->longText('answer_laos');

            $table->longText('thumbnail')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default(SurveyStatus::ACTIVE);

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
