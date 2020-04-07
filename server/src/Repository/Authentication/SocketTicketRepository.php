<?php

namespace App\Repository\Authentication;

use App\Entity\Authentication\SocketTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocketTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocketTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocketTicket[]    findAll()
 * @method SocketTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method SocketTicket|null findOneByToken(string $token)
 */
class SocketTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocketTicket::class);
    }

    // /**
    //  * @return SocketTicket[] Returns an array of SocketTicket objects
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
    public function findOneBySomeField($value): ?SocketTicket
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
