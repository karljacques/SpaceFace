<?php


namespace App\Tests\Functional;


use App\DataFixtures\Economy\MarketCommodityFixtures;
use App\DataFixtures\Economy\MarketDockableFixtures;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;

class PurchaseCommandTest extends CommodityManipulationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(MarketDockableFixtures::class);
        $this->addFixtureByName(MarketCommodityFixtures::class);

        $this->executeFixtures();

        $this->loginUser();
    }

    public function testNotEnoughMoney()
    {
        $ship = $this->getCurrentShip();
        $character = $ship->getOwner();

        $character->setMoney(0);

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getFirstSoldMarketCommodity();

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        $quantity = 3;
        $response = $this->makeBuyRequestWithMarketCommodity($marketCommodity, $quantity);

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
        $marketCommodity = $this->getFirstSoldMarketCommodity();

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // How much of the commodity is currently in storage?
        $currentStoredCommodity = $this->getMarketStoredCommodityFromMarketCommodity($marketCommodity);
        $currentStoredAmount = $currentStoredCommodity->getQuantity();

        // send request
        $quantity = 3;
        $response = $this->makeBuyRequestWithMarketCommodity($marketCommodity, $quantity);

        // expect true
        $this->assertTrue($response->success);

        // expect less money characters account
        $this->assertEquals($startingMoney - ($marketCommodity->getSell() * $quantity), $character->getMoney());

        // expect commodity in ships storage
        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $ship->getStorageComponent()->getStoredCommodities()->first();

        $this->assertEquals($marketCommodity->getCommodity()->getId(), $storedCommodity->getCommodity()->getId());
        $this->assertEquals($quantity, $storedCommodity->getQuantity());

        // expect less commodity in market's storage
        $this->assertEquals($currentStoredAmount - $quantity, $currentStoredCommodity->getQuantity());
    }

    protected function makeRequest(int $marketCommodityId, int $quantity, int $price)
    {
        $uri = '/economy/market/purchase';

        $data = json_encode([
            'market_commodity_id' => $marketCommodityId,
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $this->sendCommandRequest($uri, $data);
    }


    /**
     * @param MarketCommodity $marketCommodity
     * @param int $quantity
     * @return mixed
     */
    protected function makeBuyRequestWithMarketCommodity(MarketCommodity $marketCommodity, int $quantity)
    {
        return $this->makeRequest(
            $marketCommodity->getId(),
            $quantity,
            $marketCommodity->getSell()
        );
    }
}
