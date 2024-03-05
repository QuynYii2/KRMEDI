<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeBusiness extends Enum
{
    const CLINICS = 'CLINICS';
    const PHARMACIES = 'PHARMACIES';
    const HOSPITALS = 'HOSPITALS';
}
