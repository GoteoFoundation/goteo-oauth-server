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

use App\DataTransformer\UserToArrayTransformer;
use App\Entity\User;
use App\Repository\UserRepository;
use App\UseCase\GetUserInfoUseCase;
use PHPUnit\Framework\TestCase;

class GetUserInfoUseCaseTest extends TestCase
{
    private const BASE_AVATAR_URL = "http://BASE_AVATAR_URL/";

    public function testGivenUserWithPictureWhenTransformerIsExecutedThenArrayIsReturned(): void
    {
        $user = $this->getUser();
        $useCase = new GetUserInfoUseCase(
            $this->getUserRepositoryMock($user),
            $this->getUserToArrayTransformerMock(),
        );

        $response = $useCase->execute("user_id", self::BASE_AVATAR_URL);

        $this->assertIsArray($response);
    }

    private function getUser(): User
    {
        $user = new User();
        $user
            ->setId("user_id")
            ->setName("user_name")
            ->setPicture(null)
            ->setEmail("user@email.com")
            ->setIsConfirmed(true)
            ->setLocale("ca")
        ;

        return $user;
    }

    private function getUserRepositoryMock(User $user): UserRepository
    {
        $mock = $this->createMock(UserRepository::class);
        $mock->expects($this->once())
            ->method("findById")
            ->with($user->getId())
            ->willReturn($user);

        return $mock;
    }

    private function getUserToArrayTransformerMock(): UserToArrayTransformer
    {
        $mock = $this->createMock(UserToArrayTransformer::class);
        $mock->expects($this->once())
            ->method("transform")
            ->with($this->isInstanceOf(User::class), self::BASE_AVATAR_URL)
            ->willReturn([]);

        return $mock;
    }
}
