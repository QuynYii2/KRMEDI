<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermissonRole extends Enum
{
    const RECRUITMENT = 'RECRUITMENT';
    const SELLING_BUYING = 'SELLING_BUYING';
    const CONSULTATION = 'CONSULTATION';
    const NEWS_EVENTS = 'NEWS_EVENTS';
    const FREE_COUPONS = 'FREE_COUPONS';
    const LOCATIONS = 'LOCATIONS';
    const ONLINE_SHOPPING = 'ONLINE_SHOPPING';
}
