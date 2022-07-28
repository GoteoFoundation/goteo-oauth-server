<?php

namespace App\Tests\Unit\DataTransformer;

use App\DataTransformer\ApiTokenToArrayTransformer;
use App\Entity\ApiToken;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ApiTokenToArrayTransformerTest extends TestCase
{
    private const DUMMY_USER_ID = "user_id";
    private const DUMMY_API_TOKEN = "user_api_token";

    public function testSHA1HashedPasswordIsValid(): void
    {
        $apiToken = $this->getApiToken();
        $transformer = new ApiTokenToArrayTransformer();
        $response = $transformer->transform($apiToken);

        $this->assertEquals(
            [
                "id" => self::DUMMY_USER_ID,
                "api_token" => self::DUMMY_API_TOKEN,
                "expires_at" => $apiToken->getExpiresAt(),
            ],
            $response
        );
    }

    private function getApiToken(): ApiToken
    {
        $apiToken = new ApiToken();
        $apiToken
            ->setUserId(self::DUMMY_USER_ID)
            ->setApiToken(self::DUMMY_API_TOKEN)
            ->setExpiresAt(new DateTimeImmutable())
        ;

        return $apiToken;
    }
}
