<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const BLOCKED = 'BLOCKED';
    const DELETED = 'DELETED';
    const PENDING = 'PENDING';
}
