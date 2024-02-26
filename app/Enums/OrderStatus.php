<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const PROCESSING =   'PROCESSING';
    const WAIT_PAYMENT =   'WAITING FOR PAYMENT';
    const SHIPPING = 'SHIPPING';
    const DELIVERED = 'DELIVERED';
    const CANCELED = 'CANCELED';
    const DELETED = 'DELETED';
}
