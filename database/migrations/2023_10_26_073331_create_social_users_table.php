<?php

use App\Enums\SocialUserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('facebook');
            $table->string('instagram')->nullable();
            $table->string('youtube');
            $table->string('tiktok');
            $table->string('google_review')->nullable();
            $table->longText('other');
            $table->string('status')->default(SocialUserStatus::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_users');
    }
};
