<?php

namespace App\Repository;

use App\Entity\JumpNode;
use App\Repository\Traits\LocatableEntityRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JumpNode|null find($id, $lockMode = null, $lockVersion = null)
 * @method JumpNode|null findOneBy(array $criteria, array $orderBy = null)
 * @method JumpNode[]    findAll()
 * @method JumpNode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JumpNodeRepository extends ServiceEntityRepository
{
    use LocatableEntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JumpNode::class);
    }
}
