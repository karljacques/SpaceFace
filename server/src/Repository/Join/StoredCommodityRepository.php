<?php

namespace App\Repository\Join;

use App\Entity\Join\StoredCommodity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoredCommodity|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoredCommodity|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoredCommodity[]    findAll()
 * @method StoredCommodity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoredCommodityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoredCommodity::class);
    }

    // /**
    //  * @return StoredCommodity[] Returns an array of StoredCommodity objects
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
    public function findOneBySomeField($value): ?StoredCommodity
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
