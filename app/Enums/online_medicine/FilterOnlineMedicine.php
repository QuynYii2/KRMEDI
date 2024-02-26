<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class FilterOnlineMedicine extends Enum
{
    const ALL = '0';
    const HEALTH = '1';
    const BEAUTY = '2';
    const PET = '3';

    const NAME = [
        self::ALL => 'Tất cả',
        self::HEALTH => 'Sức khỏe',
        self::BEAUTY => 'Làm đẹp',
        self::PET => 'Thú cưng',
    ];
    const NAME_EN = [
        self::ALL => 'All',
        self::HEALTH => 'Health',
        self::BEAUTY => 'Beauty',
        self::PET => 'Pet',
    ];
}
