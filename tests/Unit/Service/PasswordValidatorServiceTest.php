<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\Tests\Unit\Service;

use App\Service\PasswordValidatorService;
use PHPUnit\Framework\TestCase;

class PasswordValidatorServiceTest extends TestCase
{
    public function testSHA1HashedPasswordIsValid(): void
    {
        $plainTextPassword = "test-password";
        $hashedPassword = sha1($plainTextPassword);

        $passwordValidatorService = new PasswordValidatorService();
        $response = $passwordValidatorService->isPasswordValid(
            $hashedPassword,
            $plainTextPassword
        );

        $this->assertTrue($response);
    }

    public function testPasswordValidatorFailsWhenHashedPasswordDoesNotMatchPlainTextPassword(): void
    {
        $plainTextPassword = "test-password";
        $realPlainTextPasswordUsed = "test-password2";
        $hashedPassword = sha1($plainTextPassword);

        $passwordValidatorService = new PasswordValidatorService();
        $response = $passwordValidatorService->isPasswordValid(
            $hashedPassword,
            $realPlainTextPasswordUsed
        );

        $this->assertFalse($response);
    }
}
