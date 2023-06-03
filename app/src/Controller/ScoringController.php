<?php

namespace App\Controller;

use App\Form\UserRegType;
use App\Model\Entity\User;
use App\Repository\UserRepository;
use App\Service\Scoring\ScoringService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ScoringController extends AbstractController
{
    public function create(Request $request, ScoringService $scoringService, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(UserRegType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $scoringService->countScores($user);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app.scoring.list');
        }

        return $this->render('user_reg_form.html.twig', [
            'form' => $form,
        ]);
    }

    public function edit(Request $request, int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user instanceof User) {
            throw new BadRequestException('Пользователь не найден');
        }

        $form = $this->createForm(UserRegType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app.scoring.list');
        }

        return $this->render('user_reg_form.html.twig', [
            'form' => $form,
        ]);
    }

    public function list(Request $request, UserRepository $userRepository): Response
    {
        $offset = max(0, $request->query->getInt('page', 0));
        $paginator = $userRepository->getPaginator($offset);

        return $this->render('user_list.html.twig', [
            'userList' => $paginator,
            'previous' => $offset - UserRepository::PER_PAGE,
            'next' => min(count($paginator), $offset + UserRepository::PER_PAGE),
        ]);
    }
}
