<?php

namespace App\Service\Scoring;

use App\Model\EducationEnum;
use LogicException;

enum EducationScoresEnum: int
{
    case Higher = 15;
    case Special = 10;
    case School = 5;

    public static function getScores(string $education): int
    {
        return match ($education) {
            EducationEnum::Higher->value => self::Higher->value,
            EducationEnum::Special->value => self::Special->value,
            EducationEnum::School->value => self::School->value,
            default => throw new LogicException(sprintf('Unknown education "%s"', $education))
        };
    }
}
