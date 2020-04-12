<?php

namespace App\Repository;

use App\Entity\Dockable;
use App\Repository\Traits\LocatableEntityRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dockable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dockable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dockable[]    findAll()
 * @method Dockable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DockableRepository extends ServiceEntityRepository
{
    use LocatableEntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dockable::class);
    }
}
