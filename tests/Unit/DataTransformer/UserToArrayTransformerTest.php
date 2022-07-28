<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\Tests\Unit\DataTransformer;

use App\DataTransformer\ApiTokenToArrayTransformer;
use App\DataTransformer\UserToArrayTransformer;
use App\Entity\ApiToken;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserToArrayTransformerTest extends TestCase
{
    private const BASE_AVATAR_URL = "http://BASE_AVATAR_URL/";

    public function testGivenUserWithPictureWhenTransformerIsExecutedThenArrayIsReturned(): void
    {
        $user = $this->getUser("user_picture.jpg");
        $transformer = new UserToArrayTransformer();
        $response = $transformer->transform($user, self::BASE_AVATAR_URL);

        $this->assertEquals(
            [
                "sub" => $user->getId(),
                "name" => $user->getName(),
                "username" => $user->getId(),
                "picture" => self::BASE_AVATAR_URL . $user->getPicture(),
                "email" => $user->getEmail(),
                "email_verified" => $user->isConfirmed(),
                "locale" => $user->getLocale(),
            ],
            $response
        );
    }

    private function getUser(?string $picture): User
    {
        $user = new User();
        $user
            ->setId("user_id")
            ->setName("user_name")
            ->setPicture($picture)
            ->setEmail("user@email.com")
            ->setIsConfirmed(true)
            ->setLocale("ca")
        ;

        return $user;
    }

    public function testGivenUserWithoutPictureWhenTransformerIsExecutedThenArrayWithNullPictureIsReturned(): void
    {
        $user = $this->getUser(null);
        $transformer = new UserToArrayTransformer();
        $response = $transformer->transform($user, self::BASE_AVATAR_URL);

        $this->assertEquals(
            [
                "sub" => $user->getId(),
                "name" => $user->getName(),
                "username" => $user->getId(),
                "picture" => null,
                "email" => $user->getEmail(),
                "email_verified" => $user->isConfirmed(),
                "locale" => $user->getLocale(),
            ],
            $response
        );
    }
}
