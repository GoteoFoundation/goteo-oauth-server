<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\PasswordValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        UserRepository $userRepository,
    ): Response {
        $passwordValidatorService = new PasswordValidatorService();
        $users = $userRepository->findAll();
        dump($users);

        foreach ($users as $user) {
            $isValidPassword = $passwordValidatorService->isPasswordValid(
                $user->getPassword(),
                "TEST-PASSWORD"
            );

            if ($isValidPassword) {
                dump("Password valid for: " . $user->getEmail());
            }
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
