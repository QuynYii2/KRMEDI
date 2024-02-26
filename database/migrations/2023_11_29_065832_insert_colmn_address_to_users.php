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
        Schema::table('users', function (Blueprint $table) {
            $table->string('detail_address')->nullable()->after('provider_name');
            $table->string('detail_address_en')->nullable()->after('detail_address');
            $table->string('detail_address_laos')->nullable()->after('detail_address_en');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['detail_address', 'detail_address_en', 'detail_address_laos']);
        });
    }
};
