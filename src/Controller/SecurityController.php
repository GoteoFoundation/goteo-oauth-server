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

use App\EventListener\AuthorizationRequestResolverSubscriber;
use App\Form\AuthorizationType;
use App\Repository\UserRepository;
use League\Bundle\OAuth2ServerBundle\Repository\ClientRepository;
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    private ClientRepository $clientRepository;
    private UserRepository $userRepository;

    public function __construct(
        ClientRepository $clientRepository
    ) {
      $this->clientRepository = $clientRepository;
    }

    #[Route('/{_locale}/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/{_locale}/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/{_locale}/consent', name: 'app_consent')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function consent(Request $request): Response
    {
        $clientId = $request->query->getAlnum('client_id');
        $client = $clientId ? $this->clientRepository->getClientEntity($clientId): null;

        $form = $this->createForm(AuthorizationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            switch ($data['accept_or_refuse']) {
                case 'accept':
                    $request->getSession()->set(AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT, true);
                    break;
                case 'refuse':
                    $request->getSession()->set(AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT, false);
                    break;
            }

            return $this->redirectToRoute('oauth2_authorize', $request->query->all());
        }

        return $this->render('oauth2/authorization.html.twig', [
            'form' => $form->createView(),
            'client' => $client
        ]);
    }
}
