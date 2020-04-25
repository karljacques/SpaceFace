<?php


namespace App\Tests\Functional;


class PurchaseCommandTest extends GameTestCase
{
    public function testNotEnoughMoney()
    {

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
