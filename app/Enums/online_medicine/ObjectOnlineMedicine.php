<?php declare(strict_types=1);

namespace App\Enums\online_medicine;

use BenSampo\Enum\Enum;

final class ObjectOnlineMedicine extends Enum
{
    //for kids, for women, for men, for adult
    const KIDS = '1';
    const FOR_WOMEN = '2';
    const FOR_MEN = '3';
    const FOR_ADULT = '4';


    const NAME = [
        self::KIDS => 'Trẻ em',
        self::FOR_WOMEN => 'Dành cho phụ nữ',
        self::FOR_MEN => 'Dành cho phái mạnh',
        self::FOR_ADULT => 'Dành cho người lớn',
    ];

    const NAME_EN = [
        self::KIDS => 'Kids',
        self::FOR_WOMEN => 'For women',
        self::FOR_MEN => 'For men',
        self::FOR_ADULT => 'For adult',
    ];
}
