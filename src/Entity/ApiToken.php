<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApiTokenRepository::class)]
#[ORM\Table(name: "user_api")]
class ApiToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50)]
    private $userId;

    #[ORM\Column(name: 'key', type: 'string', length: 50)]
    private $apiToken;

    #[ORM\Column(name: 'expiration_date', type: 'datetime_immutable', nullable: true)]
    private $expiresAt;

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTimeImmutable $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
