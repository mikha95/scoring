<?php

namespace App\Service\Scoring;

enum DomainScoresEnum: int
{
    case Gmail = 10;
    case Yandex = 8;
    case Mail = 6;
    case Other = 3;

    public const GMAIL = 'gmail';
    public const YANDEX = 'yandex';
    public const MAIL = 'mail';


    public static function getScores(string $domain): int
    {
        return match ($domain) {
            self::GMAIL => self::Gmail->value,
            self::YANDEX => self::Yandex->value,
            self::MAIL => self::Mail->value,
            default => self::Other->value
        };
    }
}
