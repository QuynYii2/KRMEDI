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
        Schema::table('clinics', function (Blueprint $table){
            $table->string('address')->nullable()->change();
            $table->longText('gallery')->nullable()->change();
            $table->string('status')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->integer('count')->nullable()->change();
            $table->string('time_work')->nullable()->change();
            $table->double('average_star')->nullable()->change();
            $table->text('representative_doctor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table){
            $table->string('address')->nullable(false)->change();
            $table->longText('gallery')->nullable(false)->change();
            $table->string('status')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
            $table->integer('count')->nullable(false)->change();
            $table->string('time_work')->nullable(false)->change();
            $table->double('average_star')->nullable(false)->change();
            $table->text('representative_doctor')->nullable(false)->change();
        });
    }
};
