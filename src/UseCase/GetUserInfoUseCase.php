<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\UseCase;

use App\DataTransformer\UserToArrayTransformer;
use App\Repository\UserRepository;

class GetUserInfoUseCase
{
    private UserRepository $userRepository;
    private UserToArrayTransformer $transformer;

    public function __construct(
        UserRepository $userRepository,
        UserToArrayTransformer $transformer,
    ) {
        $this->userRepository = $userRepository;
        $this->transformer = $transformer;
    }

    public function execute(
        string $userId,
        string $baseAvatarUrl,
    ): array {
        $user = $this->userRepository->findById($userId);

        return $this->transformer->transform($user, $baseAvatarUrl);
    }
}
