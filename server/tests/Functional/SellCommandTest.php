<?php


namespace App\Tests\Functional;


use App\DataFixtures\Economy\MarketCommodityFixtures;
use App\DataFixtures\Economy\MarketDockableFixtures;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;

class SellCommandTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(MarketDockableFixtures::class);
        $this->addFixtureByName(MarketCommodityFixtures::class);

        $this->executeFixtures();
    }

    public function testSuccessful()
    {
        $ship = $this->getCurrentShip();
        $character = $ship->getOwner();
        $startingMoney = $character->getMoney();

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['buy' => 'DESC'])[0];

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // Store this commodity in ships hold
        $storedCommodity = new StoredCommodity();
        $storedCommodity->setQuantity(10)
            ->setCommodity($marketCommodity->getCommodity())
            ->setStorage($ship->getStorageComponent());

        $this->getEntityManager()->persist($storedCommodity);
        $this->getEntityManager()->flush();

        // Hold much is currently in Stations storage?
        /** @var StoredCommodity|null $currentStoredCommodity */
        $currentStoredCommodity = $this->getRepository(StoredCommodity::class)->findOneBy(
            [
                'storage' => $marketCommodity->getMarket()->getStorage(),
                'commodity' => $marketCommodity->getCommodity()
            ]
        );

        $currentStoredAmount = $currentStoredCommodity ? $currentStoredCommodity->getQuantity() : 0;

        // send request
        $response = $this->makeRequest(
            $marketCommodity->getCommodity()->getId(),
            $marketCommodity->getMarket()->getId(),
            3,
            $marketCommodity->getBuy()
        );

        // expect true
        $this->assertTrue($response->success);

        // expect less money characters account
        $this->assertEquals($startingMoney + ($marketCommodity->getBuy() * 3), $character->getMoney());

        // expect less commodity in ships storage
        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $ship->getStorageComponent()->getStoredCommodities()->first();

        $this->assertEquals($marketCommodity->getCommodity()->getId(), $storedCommodity->getCommodity()->getId());
        $this->assertEquals(7, $storedCommodity->getQuantity());

        // expect commodity in market's storage
        $currentStoredCommodity = $this->getRepository(StoredCommodity::class)->findOneBy(
            [
                'storage' => $marketCommodity->getMarket()->getStorage(),
                'commodity' => $marketCommodity->getCommodity()
            ]
        );

        $this->assertEquals($currentStoredAmount + 3, $currentStoredCommodity->getQuantity());
    }

    protected function makeRequest(int $commodityId, int $marketId, int $quantity, int $price)
    {
        $uri = '/economy/market/sell';

        $data = json_encode([
            'commodity_id' => $commodityId,
            'market_id' => $marketId,
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $this->sendCommandRequest($uri, $data);
    }

    public function testNoCommodityToSell()
    {
        $ship = $this->getCurrentShip();

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['buy' => 'DESC'])[0];

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // send request
        $response = $this->makeRequest(
            $marketCommodity->getCommodity()->getId(),
            $marketCommodity->getMarket()->getId(),
            3,
            $marketCommodity->getBuy()
        );

        // expect true
        $this->assertFalse($response->success);
    }
}
