<?php

namespace App\Service\Scoring;

use App\Model\Entity\User;

class ScoringService
{
    public function countScores(User $user): void
    {
        $phoneScores = $this->getPhoneScores($user->getPhone());
        $domainScores = $this->getDomainScores($user->getEmail());
        $educationScores = EducationScoresEnum::getScores($user->getEducation());
        $agreeScores = AgreeScoresEnum::getScores($user->getAgree());

        $user
            ->setPhoneScore($phoneScores)
            ->setEmailScore($domainScores)
            ->setEducationScore($educationScores)
            ->setAgreeScore($agreeScores)
            ->setSum($phoneScores + $domainScores + $educationScores + $agreeScores)
        ;
    }

    private function getPhoneScores(string $phone): int
    {
        $phone = preg_replace('/\D/', '', $phone);
        $code = (int) substr($phone, -10, 3);

        return OperatorScoresEnum::getScores($code);
    }

    private function getDomainScores(string $email): int
    {
        $domain = preg_replace('/.*@(\w+)\..*/', '$1', $email);

        return DomainScoresEnum::getScores($domain);
    }
}
