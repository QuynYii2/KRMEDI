<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CartStatus extends Enum
{
    const PENDING = 'PENDING';
    const COMPLETE = 'COMPLETE';
}
