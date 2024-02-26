<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeUser extends Enum
{
    //
    const PHARMACEUTICAL_COMPANIES = 'PHARMACEUTICAL COMPANIES';
    const HOSPITALS = 'HOSPITALS';
    const CLINICS = 'CLINICS';
    const PHARMACIES = 'PHARMACIES';
    const SPAS = 'SPAS';
    const OTHERS = 'OTHERS';
    //
    const DOCTORS = 'DOCTORS';
    const PHAMACISTS = 'PHAMACISTS';
    const THERAPISTS = 'THERAPISTS';
    const ESTHETICIANS = 'ESTHETICIANS';
    const NURSES = 'NURSES';
    //
    const PAITENTS = 'PAITENTS';
    const NORMAL_PEOPLE = 'NORMAL PEOPLE';

}
