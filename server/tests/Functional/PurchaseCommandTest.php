<?php


namespace App\Tests\Functional;


class PurchaseCommandTest extends GameTestCase
{
    public function testNotEnoughMoney()
    {
        // Get a market commodity to buy

        // Dock at that market's dockable

        // send request

        // expect false
    }

    public function testSuccessful()
    {
        // Get a market commodity to buy

        // Dock at that market's dockable

        // send request

        // expect true

        // expect less money characters account

        // expect commodity in ships storage

        // expect less commodity in market's storage
    }

    protected function makeRequest(int $commodityId, int $marketId, int $quantity, int $price)
    {
        $uri = '/commodity/purchase';

        $data = json_encode([
            'commodity_id' => $commodityId,
            'market_id' => $marketId,
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $this->sendCommandRequest($uri, $data);
    }
}
