<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */

namespace App\Service;

use PHPassLib\Application\Context;

class PasswordValidatorService {
    // This is logarithmic! May be incremented as computer power increments.
    private const ENCRYPTION_ROUNDS = 12;

    private string $hashed_password;
    private bool $sha1_encoding = false;
    private bool $bcrypt_encoding = false;
    private Context $context;

    function __construct() {
        $this->setContext();
    }

    private function setContext(): void
    {
        $this->context = new Context;
        $this->context->addConfig(
            'bcrypt',
            ['rounds' => self::ENCRYPTION_ROUNDS]
        );
    }

    public function isPasswordValid(
        string $hashedPassword,
        string $plainPasswordToCheck
    ): bool {
        $this->setHashedPassword($hashedPassword);

        if (!$this->isSHA1($plainPasswordToCheck)) {
            // For compatibility, all passwords will be pre-encoded with an SHA-1 algorithm
            $compare_password = sha1($plainPasswordToCheck);
        }
        if ($this->bcrypt_encoding) {
            // For compatibility with the GitHub version
            return $this->hashed_password === crypt($plainPasswordToCheck, $this->hashed_password);
        }

        if ($this->sha1_encoding) {
            return $compare_password === $this->hashed_password;
        }

        return password_verify($compare_password, $this->hashed_password);
    }

    private function setHashedPassword(string $hashedPassword): void
    {
        // Old database passwords are encoded in plain SHA-1
        $this->sha1_encoding = $this->isSHA1($hashedPassword);
        $this->bcrypt_encoding = $this->isOldBcrypt($hashedPassword);
        $this->hashed_password = $hashedPassword;
    }

    function isSHA1(string $str): bool
    {
        return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    }

    function isOldBcrypt(string $str): bool
    {
        return str_starts_with($str, '$1$');
    }

}
