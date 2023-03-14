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
use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("{_locale}/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("{_locale}/consent", name="app_consent")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function consent(Request $request): Response
    {
        $form = $this->createForm(AuthorizationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            switch (true) {
                case $data["accept"]:
                    $request->getSession()->set(AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT, true);
                    break;
                case $data["refuse"]:
                    $request->getSession()->set(AuthorizationRequestResolverSubscriber::SESSION_AUTHORIZATION_RESULT, false);
                    break;
            }

//            return $this->redirect($request->getSchemeAndHttpHost() . "/authorize");
            return $this->redirectToRoute('oauth2_authorize', $request->query->all());
        }

        return $this->render('oauth2/authorization.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
