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
        Schema::create('post_infos', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('title_en')->nullable();
            $table->mediumText('thumbnail');
            $table->mediumText('short_description')->nullable();
            $table->mediumText('short_description_en')->nullable();
            $table->longText('full_description')->nullable();
            $table->longText('full_description_en')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_infos');
    }
};
