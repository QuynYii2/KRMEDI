<?php

use App\Enums\NewEventStatus;
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
        Schema::create('short_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('title');
            $table->string('title_en');
            $table->string('title_laos');

            $table->integer('views')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('reactions')->default(0);

            $table->longText('file');
            $table->string('status')->default(NewEventStatus::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_videos');
    }
};
