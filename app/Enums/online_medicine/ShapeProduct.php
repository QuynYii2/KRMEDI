<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class ShapeProduct extends Enum
{
    /* Dạng thuốc tiêm */
    const INJECTION = 'INJECTION';
    /* Dạng dung dịch */
    const SOLUTION = 'SOLUTION';
    /* Dạng viên sủi */
    const EFFERVESCENT = 'EFFERVESCENT';
    /* Dạng bột */
    const POWDER = 'POWDER';
    /* Dạng viên nén */
    const TABLET = 'TABLET';
    /* Dạng viên nang */
    const CAPSULE = 'CAPSULE';
    /* Dạng khác */
    const OTHER = 'OTHER';
}
