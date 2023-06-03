<?php

namespace App\DataFixtures;

use App\Model\EducationEnum;
use App\Model\Entity\User;
use App\Service\Scoring\ScoringService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserFixtures extends Fixture
{
    protected Generator $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create('ru_RU');

        $scoringService = new ScoringService();

        for ($i = 0; $i < 50; ++$i) {
            $user = (new User())
                ->setName($this->faker->firstName)
                ->setSurname($this->faker->lastName)
                ->setPhone(sprintf('+79%d', rand(100000000, 999999999)))
                ->setEmail($this->generateEmail())
                ->setEducation(array_rand(EducationEnum::getCases()))
                ->setAgree($this->faker->boolean())
            ;

            $scoringService->countScores($user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function generateEmail(): string
    {
        $yandex = sprintf('%s@yandex.ru', $this->faker->word);
        $mail = sprintf('%s@mail.ru', $this->faker->word);

        return array_rand(array_flip([$this->faker->freeEmail, $yandex, $mail]));
    }
}
