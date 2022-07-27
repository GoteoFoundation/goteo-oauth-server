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

use App\DataTransformer\ApiTokenToArrayTransformer;
use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;

class GetUserApiTokenUseCase
{
    private ApiTokenRepository $apiTokenRepository;
    private ApiTokenToArrayTransformer $transformer;

    public function __construct(
        ApiTokenRepository $apiTokenRepository,
        ApiTokenToArrayTransformer $transformer,
    ) {
        $this->apiTokenRepository = $apiTokenRepository;
        $this->transformer = $transformer;
    }

    public function execute(string $userId): array
    {
        $apiToken = $this->getApiToken($userId);

        return $this->transformer->transform($apiToken);
    }

    private function getApiToken(string $userId): ApiToken
    {
        return $this->apiTokenRepository->findOneBy([
            "userId" => $userId,
        ]);
    }
}
