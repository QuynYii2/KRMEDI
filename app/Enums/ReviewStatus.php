<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ReviewStatus extends Enum
{
    const APPROVED =   'APPROVED';
    const PENDING =   'PENDING';
    const REFUSE = 'REFUSE';
    const DELETED = 'DELETED';
}
