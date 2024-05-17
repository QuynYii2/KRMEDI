<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const PROCESSING =   'ASSIGNING';
    const WAIT_PAYMENT =   'ACCEPTED';
    const DELIVERED = 'IN PROCESS';
    const SHIPPING = 'COMPLETED';
    const CANCELED = 'CANCELED';
    const DELETED = 'DELETED';
    const REFUND = 'REFUND';
}
