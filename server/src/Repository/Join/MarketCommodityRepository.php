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

    public function findOneBySellPrice(int $marketId, int $commodityId, int $price): ?MarketCommodity
    {
        return $this->findOneBy([
            'market' => $marketId,
            'commodity' => $commodityId,
            'sell' => $price
        ]);
    }

    public function findOneByBuyPrice($marketId, $commodityId, $price): ?MarketCommodity
    {
        return $this->findOneBy([
            'market' => $marketId,
            'commodity' => $commodityId,
            'buy' => $price
        ]);
    }
}
