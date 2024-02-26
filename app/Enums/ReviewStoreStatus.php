<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReviewStoreStatus extends Enum
{
    const APPROVED = 'APPROVED';
    const PENDING = 'PENDING';
    const REFUSE = 'REFUSE';
    const DELETED = 'DELETED';
}
