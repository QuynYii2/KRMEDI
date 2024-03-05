<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RelationshipFamily extends Enum
{
    const Chủ_hộ = '1';
    const Vợ = '2';
    const Chồng = '3';
    const Ông = '4';
    const Bà = '5';
    const Bố = '6';
    const Mẹ = '7';
    const Anh = '8';
    const Em = '9';
    const Chị = '10';
    const Con = '11';
    const Cháu = '12';

    public static function getLabels(): array
    {
        return [
            self::Chủ_hộ => 'Chủ hộ',
            self::Vợ => 'Vợ',
            self::Chồng => 'Chồng',
            self::Ông => 'Ông',
            self::Bà => 'Bà',
            self::Bố => 'Bố',
            self::Mẹ => 'Mẹ',
            self::Anh => 'Anh',
            self::Em => 'Em',
            self::Chị => 'Chị',
            self::Con => 'Con',
            self::Cháu => 'Cháu',
        ];
    }
}
