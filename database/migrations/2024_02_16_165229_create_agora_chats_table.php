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
        Schema::create('agora_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_1');
            $table->unsignedBigInteger('user_id_2');

            $table->string('appid');
            $table->mediumText('token');
            $table->string('uid')->nullable();
            $table->string('channel');

            // Add check for unique user_id_1 and user_id_2
            $table->unique(['user_id_1', 'user_id_2']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agora_chats');
    }
};
