<?php

namespace App\Repository;

use App\Entity\Invest;
use App\Entity\InvestReward;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Orm\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invest>
 *
 * @method Invest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invest[]    findAll()
 * @method Invest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invest::class);
    }

    /**
     * @return Invest[] Returns an array of Invest objects
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.userId = :val')
            ->setParameter('val', $user->getId())
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function hasUserInvestedInReward(User $user, int $reward_id): bool
    {
        return (bool) $this->createQueryBuilder('i')
            ->select('i')
            ->innerJoin(InvestReward::class, 'ir', 'WITH', 'ir.invest = i.id')
            ->where('i.userId = :user_id AND ir.reward = :reward_id and i.status = 1')
            ->setParameter(':user_id', $user->getId())
            ->setParameter(':reward_id', $reward_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function hasUserInvestedInRewardLastMonth(User $user, int $reward_id): bool
    {
        return (bool) $this->createQueryBuilder('i')
            ->select('i')
            ->innerJoin(InvestReward::class, 'ir', 'WITH', 'ir.invest = i.id')
            ->where('i.status = 1 and i.userId = :user_id AND ir.reward = :reward_id AND i.invested >= DATE_SUB(CURRENT_DATE(), 1, \'MONTH\')')
            ->setParameter(':user_id', $user->getId())
            ->setParameter(':reward_id', $reward_id)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
