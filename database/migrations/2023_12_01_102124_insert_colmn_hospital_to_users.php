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
            $table->string('hospital')->nullable()->after('commune_id');
            $table->string('hospital_en')->nullable()->after('hospital');
            $table->string('hospital_laos')->nullable()->after('hospital_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['hospital', 'hospital_en', 'hospital_laos']);
        });
    }
};
