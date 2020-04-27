<?php


namespace App\Service\Factories\Command\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Entity\Ship;
use App\Repository\Join\MarketCommodityRepository;
use App\Service\Factories\Command\CommandFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class PurchaseCommandFactory implements CommandFactoryInterface
{
    protected MarketCommodityRepository $marketCommodityRepository;

    public function __construct(MarketCommodityRepository $marketCommodityRepository)
    {
        $this->marketCommodityRepository = $marketCommodityRepository;
    }

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $commodityId = $request->get('commodity_id');
        $marketId = $request->get('market_id');
        $price = $request->get('price');


        $marketCommodity = $this->marketCommodityRepository->findOneBySellPrice($marketId, $commodityId, $price);

        return new PurchaseCommand($ship, $marketCommodity, $request->get('quantity'));
    }

    public function getSchema(): string
    {
        return 'economy/market/purchase.json';
    }
}
