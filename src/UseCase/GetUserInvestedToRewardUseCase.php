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

use App\Repository\InvestRepository;
use App\Repository\UserRepository;

class GetUserInvestedToRewardUseCase
{
    private UserRepository $userRepository;
    private InvestRepository $investRepository;

    public function __construct(
        UserRepository $userRepository,
        InvestRepository $investRepository
    ) {
        $this->userRepository = $userRepository;
        $this->investRepository = $investRepository;
    }

    public function execute(
        int $reward_id,
        string $userId,
    ): bool {
        $user = $this->userRepository->findById($userId);

        return $this->investRepository->hasUserInvestedInReward($user, $reward_id);
    }
}
