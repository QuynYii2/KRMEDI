<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeUser extends Enum
{
    //
    const PHARMACEUTICAL_COMPANIES = 'Công ty dược phẩm';
    const HOSPITALS = 'Bệnh viện';
    const CLINICS = 'Phòng khám';
    const PHARMACIES = 'Hiệu thuốc';
    const SPAS = 'Spa';
    const OTHERS = 'Khác';
    //
    const DOCTORS = 'Bác sĩ';
    const PHAMACISTS = 'Dược sĩ';
    const THERAPISTS = 'Nhà trị liệu';
    const ESTHETICIANS = 'Nhân viên thẩm mỹ';
    const NURSES = 'Y tá';
    //
    const PAITENTS = 'Bệnh nhân';
    const NORMAL_PEOPLE = 'Người bình thường';
}

