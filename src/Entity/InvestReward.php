<?php

namespace App\Entity;

use App\Repository\InvestRewardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestRewardRepository::class)]
class InvestReward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $invest = null;

    #[ORM\Column()]
    private ?int $reward = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvest(): ?int
    {
        return $this->invest;
    }

    public function setInvest(int $invest): static
    {
        $this->invest = $invest;

        return $this;
    }

    public function getReward(): ?int
    {
        return $this->reward;
    }

    public function setReward(int $reward): static
    {
        $this->reward = $reward;

        return $this;
    }
}
