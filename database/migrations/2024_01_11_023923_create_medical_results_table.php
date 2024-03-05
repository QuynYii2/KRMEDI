<?php

use App\Enums\MedicalResultStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_results', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('address');
            $table->string('email')->nullable();
            $table->longText('service_name');
            $table->string('code');
            $table->longText('result')->nullable();
            $table->longText('result_en')->nullable();
            $table->longText('result_laos')->nullable();
            $table->longText('files')->nullable();
            $table->longText('prescriptions');
            $table->longText('detail')->nullable();
            $table->longText('detail_en')->nullable();
            $table->longText('detail_laos')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by');
            $table->string('status')->default(MedicalResultStatus::APPROVED);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_results');
    }
};
