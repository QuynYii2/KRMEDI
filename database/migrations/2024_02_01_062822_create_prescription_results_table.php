<?php

use App\Enums\PrescriptionResultStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescription_results', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('email');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('created_by');

            $table->longText('prescriptions');

            $table->string('notes')->nullable();
            $table->string('notes_en')->nullable();
            $table->string('notes_laos')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->string('status')->default(PrescriptionResultStatus::ACTIVE)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_results');
    }
};
