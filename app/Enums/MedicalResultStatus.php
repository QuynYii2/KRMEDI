<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MedicalResultStatus extends Enum
{
    const APPROVED = 'APPROVED';
    const PENDING = 'PENDING';
    const DELETED = 'DELETED';
}
