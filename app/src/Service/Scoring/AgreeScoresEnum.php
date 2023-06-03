<?php

namespace App\Service\Scoring;

enum AgreeScoresEnum: int
{
    case IsAgree = 4;
    case IsDisagree = 0;

    public static function getScores(bool $agree): int
    {
        return match ($agree) {
            true => self::IsAgree->value,
            false => self::IsDisagree->value
        };
    }
}
