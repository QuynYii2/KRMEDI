<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MentoringCategory extends Enum
{
    const ALL = '0';
    const HEALTH = '1';
    //Beauty, Losing weight, Kids, Pets, Other
    const BEAUTY = '2';
    const LOSING_WEIGHT = '3';
    const KIDS = '4';
    const PETS = '5';
    const OTHER = '6';
}
