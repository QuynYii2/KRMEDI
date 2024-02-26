<?php

use App\Enums\ClinicStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('address_detail');
            $table->string('address_detail_en')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('open_date');
            $table->timestamp('close_date')->nullable();
            $table->string('introduce');
            $table->longText('gallery');
            $table->string('status')->default(ClinicStatus::ACTIVE);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinics');
    }
};
