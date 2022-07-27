<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\DataTransformer;

use App\Entity\ApiToken;

class ApiTokenToArrayTransformer
{
    public function transform(ApiToken $apiToken): array
    {
        return [
            "id" => $apiToken->getUserId(),
            "api_token" => $apiToken->getApiToken(),
            "expires_at" => $apiToken->getExpiresAt(),
        ];
    }
}
