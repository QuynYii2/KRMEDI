<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medical_results', function (Blueprint $table) {
            $table->string('place')->nullable();
            $table->timestamp('datetime')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_results', function (Blueprint $table) {
            $table->dropColumn('place');
            $table->dropColumn('datetime');
        });
    }
};
