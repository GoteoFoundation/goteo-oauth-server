<?php

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
