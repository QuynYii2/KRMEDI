<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $translations = [
            33 => 'Công ty dược phẩm',
            34 => 'Bệnh viện',
            35 => 'Phòng khám',
            36 => 'Hiệu thuốc',
            37 => 'Spa',
            38 => 'Khác',
            39 => 'Bác sĩ',
            40 => 'Dược sĩ',
            41 => 'Nhà trị liệu',
            42 => 'Nhân viên thẩm mỹ',
            43 => 'Y tá',
            44 => 'Bệnh nhân',
            45 => 'Người bình thường',
            46 => 'Quản trị viên'
        ];

        foreach ($translations as $id => $translation) {
            DB::table('roles')->where('id', $id)->update(['name' => $translation]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $originals = [
            33 => 'PHARMACEUTICAL COMPANIES',
            34 => 'HOSPITALS',
            35 => 'CLINICS',
            36 => 'PHARMACIES',
            37 => 'SPAS',
            38 => 'OTHERS',
            39 => 'DOCTORS',
            40 => 'PHAMACISTS',
            41 => 'THERAPISTS',
            42 => 'ESTHETICIANS',
            43 => 'NURSES',
            44 => 'PAITENTS',
            45 => 'NORMAL PEOPLE',
            46 => 'ADMIN'
        ];

        foreach ($originals as $id => $original) {
            DB::table('roles')->where('id', $id)->update(['name' => $original]);
        }
    }

};
