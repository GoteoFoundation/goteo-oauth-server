<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Repository\UserRepository;
use App\Service\PasswordValidatorService;
use League\Bundle\OAuth2ServerBundle\Event\UserResolveEvent;

final class UserResolveEventSubscriber implements EventSubscriberInterface
{
    private UserRepository $userRepository;
    private PasswordValidatorService $passwordValidator;

    public function __construct(UserRepository $userRepository, PasswordValidatorService $passwordValidator)
    {
        $this->userRepository = $userRepository;
        $this->passwordValidator = $passwordValidator;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userRepository->findOneByIdentifier($event->getUsername());

        if ($user && $this->passwordValidator->isPasswordValid($user->getPassword(), $event->getPassword())) {
            $event->setUser($user);
        }
    }
    /**
     * @return array<string, mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return ['league.oauth2_server.event.user_resolve' => 'onUserResolve'];
    }
}
