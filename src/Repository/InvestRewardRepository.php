<?php

namespace App\Repository;

use App\Entity\InvestReward;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvestReward>
 *
 * @method InvestReward|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvestReward|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvestReward[]    findAll()
 * @method InvestReward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestRewardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvestReward::class);
    }
}
