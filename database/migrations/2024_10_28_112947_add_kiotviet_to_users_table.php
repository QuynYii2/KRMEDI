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
            $table->longText('client_id_kiot_viet')->nullable();
            $table->longText('client_secret_kiot_viet')->nullable();
            $table->string('retailer_kiot_viet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('client_id_kiot_viet');
            $table->dropColumn('client_secret_kiot_viet');
            $table->dropColumn('retailer_kiot_viet');
        });
    }
};
