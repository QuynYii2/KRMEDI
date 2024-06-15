<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeMedical extends Enum
{
    const DOCTORS = 'Bác sĩ';
    const PHAMACISTS = 'Dược sĩ';
    const THERAPISTS = 'Nhà trị liệu';
    const ESTHETICIANS = 'Nhân viên thẩm mỹ';
    const NURSES = 'Y tá';
}
