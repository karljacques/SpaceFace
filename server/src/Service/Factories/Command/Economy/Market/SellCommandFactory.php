<?php


namespace App\Service\Factories\Command\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\SellCommand;
use App\Entity\Ship;
use App\Repository\Join\MarketCommodityRepository;
use App\Service\Factories\Command\CommandFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SellCommandFactory implements CommandFactoryInterface
{
    protected MarketCommodityRepository $marketCommodityRepository;

    public function __construct(MarketCommodityRepository $marketCommodityRepository)
    {
        $this->marketCommodityRepository = $marketCommodityRepository;
    }

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $marketCommodityId = $request->get('market_commodity_id');
        $price = $request->get('price');

        $marketCommodity = $this->marketCommodityRepository->findOneByBuyPrice($marketCommodityId, $price);

        return new SellCommand($ship, $marketCommodity, $request->get('quantity'));
    }

    public function getSchema(): string
    {
        return 'economy/market/purchase.json';
    }
}
