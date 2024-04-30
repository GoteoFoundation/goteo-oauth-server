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
use App\UseCase\GetUserInvestsUseCase;
use App\UseCase\GetUserInvestedToRewardUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function indexNoLocale(Request $request): Response
    {
        return $this->redirectToRoute('home', ['_locale' => $request->getLocale()]);
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

    #[Route('/userInvests', name: 'userInvests')]
    public function userInvests(GetUserInvestsUseCase $useCase): Response
    {
        $response = $useCase->execute($this->getUser()->getUserIdentifier());

        return $this->json($response);
    }

    #[Route('/userInvestedToReward/{reward_id}', name: 'userInvestedToReward')]
    public function userInvestedToReward(Request $request, int $reward_id, GetUserInvestedToRewardUseCase $useCase): Response
    {
        $response = $useCase->execute($reward_id, $this->getUser()->getUserIdentifier());

        return $this->json($response);
    }

    #[Route('/{_locale}', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
