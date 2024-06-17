<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeMedical extends Enum
{
    const DOCTORS = 'DOCTORS';
    const PHAMACISTS = 'PHAMACISTS';
    const THERAPISTS = 'THERAPISTS';
    const ESTHETICIANS = 'ESTHETICIANS';
    const NURSES = 'NURSES';
}
