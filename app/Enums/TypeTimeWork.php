<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeTimeWork extends Enum
{
    const ALL = 'ALL';
    const OFFICE_HOURS = 'OFFICE HOURS';
    const ONLY_MORNING = 'ONLY MORNING';
    const ONLY_AFTERNOON = 'ONLY AFTERNOON';
    const OTHER = 'OTHER';
    const NONE = 'NONE';
}
