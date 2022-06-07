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

use App\Repository\ApiTokenRepository;
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
    public function userInfo(): Response
    {
        return $this->json([
            "sub" => $this->getUser()->getId(),
            "name" => $this->getUser()->getName(),
            "username" => $this->getUser()->getId(),
            "picture" => $this->getUser()->getPicture()
                ? $this->getParameter("BASE_AVATAR_URL") . $this->getUser()->getPicture()
                : null,
            "email" => $this->getUser()->getUserIdentifier(),
            "email_verified" => $this->getUser()->isConfirmed(),
            "locale" => $this->getUser()->getLocale(),
        ]);
    }

    #[Route('/userApiToken', name: 'userApiToken')]
    public function userApiToken(ApiTokenRepository $apiTokenRepository): Response
    {
        $apiToken = $apiTokenRepository->findOneBy([
            "userId" => $this->getUser()->getId()
        ]);

        return $this->json([
            "id" => $apiToken->getUserId(),
            "api_token" => $apiToken->getApiToken(),
            "expires_at" => $apiToken->getExpiresAt(),
        ]);
    }
}
