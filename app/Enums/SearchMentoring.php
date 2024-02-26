<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SearchMentoring extends Enum
{
    const LATEST = 'Latest';
    const MOST_COMMENTED = 'Most commented';
    const MOST_VIEWS = 'Most views';
}
