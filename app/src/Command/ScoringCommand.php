<?php

namespace App\Command;

use App\Model\Entity\User;
use App\Repository\UserRepository;
use App\Service\Scoring\ScoringService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScoringCommand extends Command
{
    protected static $defaultName = 'app:scoring';
    protected UserRepository $userRepository;
    protected ObjectManager $manager;
    protected ScoringService $scoringService;
    protected ?int $id;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $manager, ScoringService $scoringService, int $id = null)
    {
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->scoringService = $scoringService;
        $this->id = $id;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = (int) $input->getArgument('id');

        return $userId > 0 ? $this->scoringByUserId($userId, $input, $output) : $this->scoringAllUsers($input, $output);
    }

    private function scoringByUserId(int $userId, InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepository->find($userId);

        if (!$user instanceof User) {
            $output->writeln('Пользователь не найден');
            return self::FAILURE;
        }

        $this->scoringService->countScores($user);

        $this->manager->persist($user);
        $this->manager->flush();

        $this->renderTable([$user], $output);

        return self::SUCCESS;
    }

    private function scoringAllUsers(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $this->scoringService->countScores($user);
            $this->manager->persist($user);
        }

        $this->manager->flush();

        $this->renderTable($users, $output);

        return self::SUCCESS;
    }

    /**
     * @param User[] $users
     */
    private function renderTable(array $users, OutputInterface $output): void
    {
        $rows = [];

        $table = (new Table($output))
            ->setHeaders([
                'ID',
                'Имя',
                'Фамилия',
                'Телефон',
                'Email',
                'Образование',
                'Согласие',
                'Баллы за оператора',
                'Баллы за домен',
                'Баллы за образование',
                'Баллы за согласие',
                'Сумма'
            ])
        ;

        foreach ($users as $user) {
            $rows[] = [
                $user->getId(),
                $user->getName(),
                $user->getSurname(),
                $user->getPhone(),
                $user->getEmail(),
                $user->getEducationLabel(),
                $user->getAgree() ? 'Есть' : 'Нет',
                $user->getPhoneScore(),
                $user->getEmailScore(),
                $user->getEducationScore(),
                $user->getAgreeScore(),
                $user->getSum()
            ];
        }

        $table->setRows($rows);

        $table->render();
    }
}
