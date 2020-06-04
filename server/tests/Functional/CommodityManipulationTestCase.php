<?php


namespace App\Tests\Functional;


use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;

abstract class CommodityManipulationTestCase extends GameTestCase
{
    /**
     * @param Commodity $commodity
     * @param Storage $storage
     * @param int $quantity
     * @return StoredCommodity
     */
    protected function createNewStoredCommodity(Commodity $commodity, Storage $storage, int $quantity): StoredCommodity
    {
        $storedCommodity = new StoredCommodity();
        $storedCommodity->setQuantity($quantity)
            ->setCommodity($commodity)
            ->setStorage($storage);

        $this->getEntityManager()->persist($storedCommodity);
        $this->getEntityManager()->flush();

        return $storedCommodity;
    }

    /**
     * @param MarketCommodity $marketCommodity
     * @return object|null
     */
    protected function getMarketStoredCommodityFromMarketCommodity(MarketCommodity $marketCommodity)
    {
        return $this->getRepository(StoredCommodity::class)->findOneBy(
            [
                'storage' => $marketCommodity->getMarket()->getStorage(),
                'commodity' => $marketCommodity->getCommodity()
            ]
        );
    }

    protected function getFirstBoughtMarketCommodity(): ?MarketCommodity
    {
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['buy' => 'DESC'])[0];
        return $marketCommodity;
    }

    protected function getFirstSoldMarketCommodity(): ?MarketCommodity
    {
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['sell' => 'DESC'])[0];
        return $marketCommodity;
    }

}
