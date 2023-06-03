<?php

namespace App\Model;

enum EducationEnum: string
{
    case Higher = 'higher';
    case HigherLabel = 'Высшее образование';
    case Special = 'special';
    case SpecialLabel = 'Специальное образование';
    case School = 'school';
    case SchoolLabel = 'Среднее образование';
    public static function getCases(): array
    {
        return [
            self::Higher->value => self::HigherLabel->value,
            self::Special->value => self::SpecialLabel->value,
            self::School->value => self::SchoolLabel->value,
        ];
    }

    public static function getLabel(string $education): string
    {
        return self::getCases()[$education] ?? '';
    }
}
