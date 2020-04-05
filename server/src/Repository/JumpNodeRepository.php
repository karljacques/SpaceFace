<?php

namespace App\Repository;

use App\Entity\JumpNode;
use App\Util\Location;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JumpNode::class);
    }

    public function findEntryNodeByLocation(Location $location)
    {
        return $this->findBy([
            'entrySystem' => $location->getSystem(),
            'entryX' => $location->getVector()->getX(),
            'entryY' => $location->getVector()->getY()
        ]);
    }
}
