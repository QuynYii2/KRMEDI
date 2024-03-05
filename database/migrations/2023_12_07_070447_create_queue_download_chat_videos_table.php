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
        Schema::create('queue_download_chat_videos', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->string('user_id_1')->comment('Người bệnh gọi');
            $table->string('user_id_2')->comment('Bác sĩ nhận cuộc gọi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_download_chat_videos');
    }
};
