<?php

namespace App\Tests;

use App\Model\Entity\User;
use App\Service\Scoring\ScoringService;
use LogicException;
use PHPUnit\Framework\TestCase;

class ScoringCheckerTest extends TestCase
{
    public function testScoringSuccess(): void
    {
        $user = (new User())
            ->setPhone('+79129999999')
            ->setEmail('test@yandex.ru')
            ->setEducation('higher')
            ->setAgree(false)
        ;

        $scoringService = new ScoringService();

        $scoringService->countScores($user);

        $this->assertTrue($user->getSum() === 26, 'Неверное количество баллов');
    }

    public function testScoringWithInvalidEducation(): void
    {
        $user = (new User())
            ->setPhone('+79111111111')
            ->setEmail('test@test.com')
            ->setEducation('asdasd')
            ->setAgree(true)
        ;

        $scoringService = new ScoringService();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unknown education "asdasd"');

        $scoringService->countScores($user);
    }
}
