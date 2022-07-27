<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\Controller;

use App\UseCase\GetUserApiTokenUseCase;
use App\UseCase\GetUserInfoUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/userInfo', name: 'userInfo')]
    public function userInfo(GetUserInfoUseCase $useCase): Response
    {
        $response = $useCase->execute(
            $this->getUser()->getUserIdentifier(),
            $this->getParameter("BASE_AVATAR_URL")
        );

        return $this->json($response);
    }

    #[Route('/userApiToken', name: 'userApiToken')]
    public function userApiToken(GetUserApiTokenUseCase $useCase): Response
    {
        $response = $useCase->execute($this->getUser()->getUserIdentifier());

        return $this->json($response);
    }
}
