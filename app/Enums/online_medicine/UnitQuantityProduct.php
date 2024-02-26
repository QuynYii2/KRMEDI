<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class UnitQuantityProduct extends Enum
{
    /* Hộp */
    const BOX = 'BOX' ;
    /* Vỉ */
    const PACK = 'PACK';
    /* Khác */
    const OTHER = 'OTHER';
}
