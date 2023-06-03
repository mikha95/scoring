<?php

namespace App\Service\Scoring;

enum OperatorScoresEnum: int
{
    case MegaFon = 10;
    case Beeline = 5;
    case MTS = 3;
    case Other = 1;

    public static function getScores(int $code): int
    {
        return match (true) {
            in_array($code, range(920, 938)) => self::MegaFon->value,
            in_array($code, range(960, 968)) => self::Beeline->value,
            in_array($code, array_merge(range(910, 919), range(980, 989))) => self::MTS->value,
            default => self::Other->value
        };
    }
}
