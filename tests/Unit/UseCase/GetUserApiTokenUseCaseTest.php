<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\Tests\Unit\UseCase;

use App\DataTransformer\ApiTokenToArrayTransformer;
use App\Entity\ApiToken;
use App\Repository\ApiTokenRepository;
use App\UseCase\GetUserApiTokenUseCase;
use PHPUnit\Framework\TestCase;

class GetUserApiTokenUseCaseTest extends TestCase
{
    private const DUMMY_USER_ID = "user_id";

    public function testGivenAUserIdWhenTransformerIsExecutedThenArrayIsReturned(): void
    {
        $useCase = new GetUserApiTokenUseCase(
            $this->getApiTokenRepositoryMock(),
            $this->getApiTokenToArrayTransformerMock(),
        );

        $response = $useCase->execute(self::DUMMY_USER_ID);

        $this->assertIsArray($response);
    }

    private function getApiTokenRepositoryMock(): ApiTokenRepository
    {
        $mock = $this->createMock(ApiTokenRepository::class);
        $mock->expects($this->once())
            ->method("findOneBy")
            ->with(["userId" => self::DUMMY_USER_ID])
            ->willReturn(new ApiToken());

        return $mock;
    }

    private function getApiTokenToArrayTransformerMock(): ApiTokenToArrayTransformer
    {
        $mock = $this->createMock(ApiTokenToArrayTransformer::class);
        $mock->expects($this->once())
            ->method("transform")
            ->with($this->isInstanceOf(ApiToken::class))
            ->willReturn([]);

        return $mock;
    }
}
