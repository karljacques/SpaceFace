<?php

namespace App\Repository\Join;

use App\Entity\Join\MarketCommodity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarketCommodity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarketCommodity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarketCommodity[]    findAll()
 * @method MarketCommodity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarketCommodityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarketCommodity::class);
    }

    // /**
    //  * @return MarketCommodity[] Returns an array of MarketCommodity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarketCommodity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
