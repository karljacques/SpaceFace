<?php


namespace App\Repository\Traits;


use App\Entity\System;
use App\Util\BoundingBox;
use App\Util\Location;
use Doctrine\ORM\QueryBuilder;
use Tightenco\Collect\Support\Collection;

/**
 * Trait that can be applied to repositories that deal with entities
 * that have have LocationTrait applied to them
 */
trait LocatableEntityRepositoryTrait
{
    public function findWithinBounds(System $system, BoundingBox $box): Collection
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('e');

        $qb->select('e')
            ->where('e.x >= :minX
                AND e.x <= :maxX
                AND e.y >= :minY
                AND e.y <= :maxY
                AND e.system = :system');

        $qb->setParameters([
            'minX' => $box->getStart()->getX(),
            'maxX' => $box->getEnd()->getX(),
            'minY' => $box->getStart()->getY(),
            'maxY' => $box->getEnd()->getY(),
            'system' => $system
        ]);

        return collect($qb->getQuery()->getResult());
    }

    public function findByLocation(Location $location): Collection
    {
        return collect($this->findBy([
            'system' => $location->getSystem(),
            'x' => $location->getVector()->getX(),
            'y' => $location->getVector()->getY()
        ]));
    }
}
