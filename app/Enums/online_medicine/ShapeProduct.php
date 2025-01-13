<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class ShapeProduct extends Enum
{
    /* Dạng thuốc tiêm */
    const INJECTION = 'Dạng Thuốc Tiêm';
    /* Dạng dung dịch */
    const SOLUTION = 'Dạng Dung Dịch';
    /* Dạng viên sủi */
    const EFFERVESCENT = 'Dạng Viên Sủi';
    /* Dạng bột */
    const POWDER = 'Dạng Bột';
    /* Dạng viên nén */
    const TABLET = 'Dạng Viên Nén';
    /* Dạng viên nang */
    const CAPSULE = 'Dạng Viên Nang';

    const HARDCAPSULE = 'Dạng Viên Nang Cứng';
    const SOFTCAPSULE = 'Dạng Viên Nang Mềm';
    const CREAM = 'Dạng Kem Bôi';
    /* Dạng khác */
    const OTHER = 'Dạng Khác';
}
