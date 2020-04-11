<?php

namespace App\Repository;

use App\Entity\Sector;
use App\Entity\System;
use App\Util\BoundingBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tightenco\Collect\Support\Collection;

/**
 * @method Sector|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sector|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sector[]    findAll()
 * @method Sector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sector::class);
    }

    public function getSectorsWithinBounds(System $system, BoundingBox $box): Collection
    {
        $dql = /** @lang DQL */
            "SELECT s FROM App\Entity\Sector s
                WHERE s.x >= :minX
                AND s.x <= :maxX
                AND s.y >= :minY
                AND s.y <= :maxY
                AND s.system = :system
        ";

        return collect($this->getEntityManager()->createQuery($dql)->execute([
            'minX' => $box->getStart()->getX(),
            'maxX' => $box->getEnd()->getX(),
            'minY' => $box->getStart()->getY(),
            'maxY' => $box->getEnd()->getY(),
            'system' => $system
        ]));
    }
}
