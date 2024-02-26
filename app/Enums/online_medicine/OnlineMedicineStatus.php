<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class OnlineMedicineStatus extends Enum
{
    const APPROVED = 'APPROVED';
    const PENDING = 'PENDING';
    const DELETED = 'DELETED';
}
