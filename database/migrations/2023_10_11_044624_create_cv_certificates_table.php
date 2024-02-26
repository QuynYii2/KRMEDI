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
        Schema::create('cv_certificates', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Tên chứng chỉ');
            $table->string('name_en')->comment('Tên chứng chỉ = tiếng anh')->nullable();
            $table->string('licensing_unit')->comment('Đơn vị cấp (Tên trung tâm/ trường đại học)');
            $table->string('licensing_unit_en')->comment('Đơn vị cấp (Tên trung tâm/ trường đại học) = tiếng anh')->nullable();
            $table->string('from_month')->comment('Tháng cấp');
            $table->string('description')->nullable();

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
        Schema::dropIfExists('cv_certificates');
    }
};
