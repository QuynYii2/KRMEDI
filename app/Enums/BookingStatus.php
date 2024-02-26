<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;


final class BookingStatus extends Enum
{
    const PENDING = 'PENDING';
    const COMPLETE = 'COMPLETE';
    const CANCEL = 'CANCEL';
    const DELETE = 'DELETE';
    const APPROVED = 'APPROVED';
}
