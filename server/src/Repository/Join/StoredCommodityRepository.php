<?php

namespace App\Repository\Join;

use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Entity\Join\StoredCommodity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

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

    public function doesStorageContainCommodity(Storage $storage, Commodity $commodity, int $quantity): bool
    {
        $dql = /** @lang DQL */
            "SELECT 1 FROM App\Entity\Join\StoredCommodity sc
             WHERE sc.commodity = :commodity AND sc.storage = :storage
             AND sc.quantity >= :quantity";

        $query = $this->getEntityManager()->createQuery($dql);

        $query->setParameters([
            'commodity' => $commodity,
            'storage' => $storage,
            'quantity' => $quantity
        ]);

        try {
            $result = $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            throw new LogicException('This query is incorrect');
        }

        return $result !== null;
    }
}
