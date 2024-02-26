<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CategoryProductStatus extends Enum
{
    const ACTIVE = '1';
    const DELETED = '0';
    const INACTIVE = '2';

}
