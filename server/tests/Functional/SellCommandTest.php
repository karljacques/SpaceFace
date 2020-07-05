<?php


namespace App\Tests\Functional;


use App\DataFixtures\Economy\MarketCommodityFixtures;
use App\DataFixtures\Economy\MarketDockableFixtures;
use App\Entity\Join\MarketCommodity;
use App\Entity\Join\StoredCommodity;

class SellCommandTest extends CommodityManipulationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(MarketDockableFixtures::class);
        $this->addFixtureByName(MarketCommodityFixtures::class);

        $this->executeFixtures();

        $this->loginUser();
    }

    public function testSuccessful()
    {
        $ship = $this->getCurrentShip();
        $character = $ship->getOwner();
        $startingMoney = $character->getMoney();

        // Get a market commodity to buy
        /** @var MarketCommodity $marketCommodity */
        $marketCommodity = $this->getFirstBoughtMarketCommodity();

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // Store this commodity in ships hold
        $shipInitialStoredAmount = 10;
        $this->createNewStoredCommodity($marketCommodity->getCommodity(), $ship->getStorageComponent(), $shipInitialStoredAmount);

        // Hold much is currently in Stations storage?
        $marketStoredCommodity = $this->getMarketStoredCommodityFromMarketCommodity($marketCommodity);
        $marketInitialStoredAmount = $marketStoredCommodity ? $marketStoredCommodity->getQuantity() : 0;

        $quantity = 3;

        // send request
        $response = $this->makeSellRequestWithMarketCommodity($marketCommodity, $quantity);

        // expect true
        $this->assertTrue($response->success);

        // expect extra money characters account
        $this->assertEquals($startingMoney + ($marketCommodity->getBuy() * $quantity), $character->getMoney());

        // expect less commodity in ships storage
        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $ship->getStorageComponent()->getStoredCommodities()->first();

        $this->assertEquals($marketCommodity->getCommodity()->getId(), $storedCommodity->getCommodity()->getId());
        $this->assertEquals($shipInitialStoredAmount - $quantity, $storedCommodity->getQuantity());

        // expect commodity in market's storage
        $marketStoredCommodity = $this->getMarketStoredCommodityFromMarketCommodity($marketCommodity);

        $this->assertEquals($marketInitialStoredAmount + $quantity, $marketStoredCommodity->getQuantity());
    }

    protected function makeRequest(int $marketCommodityId, int $quantity, int $price)
    {
        $uri = '/economy/market/sell';

        $data = json_encode([
            'market_commodity_id' => $marketCommodityId,
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
        $marketCommodity = $this->getFirstBoughtMarketCommodity();

        // Dock at that market's dockable
        $dockable = $marketCommodity->getMarket()->getDockable();
        $ship->setDockedAt($dockable);

        // Horrid hack to instantiate the Dockable.
        // Otherwise I'm getting a nasty error about accessing a typed property in __sleep
        // Hopefully that'll get patched.
        $dockable->getX();

        // send request
        $quantity = 3;
        $response = $this->makeSellRequestWithMarketCommodity($marketCommodity, $quantity);

        // expect true
        $this->assertFalse($response->success);
    }


    /**
     * @param MarketCommodity $marketCommodity
     * @param int $quantity
     * @return mixed
     */
    protected function makeSellRequestWithMarketCommodity(MarketCommodity $marketCommodity, int $quantity)
    {
        return $this->makeRequest(
            $marketCommodity->getId(),
            $quantity,
            $marketCommodity->getBuy()
        );
    }

}
