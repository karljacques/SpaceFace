<?php

namespace App\Repository;

use App\Entity\ShipCommodity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShipCommodity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShipCommodity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShipCommodity[]    findAll()
 * @method ShipCommodity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShipCommodityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShipCommodity::class);
    }

    // /**
    //  * @return ShipCommodity[] Returns an array of ShipCommodity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShipCommodity
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
