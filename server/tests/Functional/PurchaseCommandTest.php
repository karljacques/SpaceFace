<?php


namespace App\Tests\Functional;


use App\DataFixtures\Economy\MarketCommodityFixtures;
use App\DataFixtures\Economy\MarketDockableFixtures;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;

class PurchaseCommandTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(MarketDockableFixtures::class);
        $this->addFixtureByName(MarketCommodityFixtures::class);

        $this->executeFixtures();
    }

    public function testNotEnoughMoney()
    {
        $ship = $this->getCurrentShip();
        $character = $ship->getOwner();

        $character->setMoney(0);

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['sell' => 'DESC'])[0];

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // How much of the commodity is currently in storage?
        /** @var StoredCommodity $currentStoredCommodity */
        $currentStoredCommodity = $this->getRepository(StoredCommodity::class)->findOneBy(
            [
                'storage' => $marketCommodity->getMarket()->getStorage(),
                'commodity' => $marketCommodity->getCommodity()
            ]
        );

        $currentStoredAmount = $currentStoredCommodity->getQuantity();

        // send request
        $response = $this->makeRequest(
            $marketCommodity->getCommodity()->getId(),
            $marketCommodity->getMarket()->getId(),
            3,
            $marketCommodity->getSell()
        );

        // expect false
        $this->assertFalse($response->success);
    }

    public function testSuccessful()
    {
        $ship = $this->getCurrentShip();
        $character = $ship->getOwner();
        $startingMoney = $character->getMoney();

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getRepository(MarketCommodity::class)->findBy([], ['sell' => 'DESC'])[0];

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // How much of the commodity is currently in storage?
        /** @var StoredCommodity $currentStoredCommodity */
        $currentStoredCommodity = $this->getRepository(StoredCommodity::class)->findOneBy(
            [
                'storage' => $marketCommodity->getMarket()->getStorage(),
                'commodity' => $marketCommodity->getCommodity()
            ]
        );

        $currentStoredAmount = $currentStoredCommodity->getQuantity();

        // send request
        $response = $this->makeRequest(
            $marketCommodity->getCommodity()->getId(),
            $marketCommodity->getMarket()->getId(),
            3,
            $marketCommodity->getSell()
        );

        // expect true
        $this->assertTrue($response->success);

        // expect less money characters account
        $this->assertEquals($startingMoney - ($marketCommodity->getSell() * 3), $character->getMoney());

        // expect commodity in ships storage
        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $ship->getStorageComponent()->getStoredCommodities()->first();

        $this->assertEquals($marketCommodity->getCommodity()->getId(), $storedCommodity->getCommodity()->getId());
        $this->assertEquals(3, $storedCommodity->getQuantity());

        // expect less commodity in market's storage
        $this->assertEquals($currentStoredAmount - 3, $currentStoredCommodity->getQuantity());
    }

    protected function makeRequest(int $commodityId, int $marketId, int $quantity, int $price)
    {
        $uri = '/economy/market/purchase';

        $data = json_encode([
            'commodity_id' => $commodityId,
            'market_id' => $marketId,
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $this->sendCommandRequest($uri, $data);
    }
}
