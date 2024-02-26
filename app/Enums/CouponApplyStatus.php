<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CouponApplyStatus extends Enum
{
    const USED = 'USED';
    const UNUSED = 'UNUSED';
    const CANCELED = 'CANCELED';
    const DELETED = 'DELETED';

    const PENDING = 'PENDING';
    const VALID = 'VALID';
    const INVALID = 'INVALID';
    const REWARDED = 'REWARDED';
}
