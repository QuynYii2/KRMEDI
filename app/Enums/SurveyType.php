<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use ReflectionClass;

final class SurveyType extends Enum
{
    const TEXT = 'TEXT';
    const MULTIPLE = 'MULTIPLE';
    const RADIO = 'RADIO';

    public static function getArray()
    {
        $reflectionClass = new ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
