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

use App\Entity\User;

class UserToArrayTransformer
{
    public function transform(
        User $user,
        string $baseAvatarUrl,
    ): array {
        return [
            "sub" => $user->getId(),
            "name" => $user->getName(),
            "username" => $user->getId(),
            "picture" => $user->getPicture()
                ? $baseAvatarUrl . $user->getPicture()
                : null,
            "email" => $user->getUserIdentifier(),
            "email_verified" => $user->isConfirmed(),
            "locale" => $user->getLocale(),
        ];
    }
}
