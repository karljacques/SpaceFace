<?php


namespace App\Command\Economy\Market;


use App\Command\AbstractShipCommand;
use App\Entity\Join\MarketCommodity;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;

class SellCommand extends AbstractShipCommand
{
    protected MarketCommodity $marketCommodity;
    protected int $quantity;

    public function __construct(Ship $ship, MarketCommodity $marketCommodity, int $quantity)
    {
        parent::__construct($ship);

        $this->marketCommodity = $marketCommodity;
        $this->quantity = $quantity;
    }

    public function getMarketCommodity(): MarketCommodity
    {
        return $this->marketCommodity;
    }

    public function getTotalValue(): int
    {
        return $this->marketCommodity->getBuy() * $this->getQuantity();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getValidationRules(): array
    {
        $ship = $this->getShip();
        $marketCommodity = $this->getMarketCommodity();
        $market = $marketCommodity->getMarket();
        $storageRequired = $marketCommodity->getCommodity()->getSize() * $this->getQuantity();

        return [
            new MustBeDockedAtRule($ship, $marketCommodity->getMarket()->getDockable()),
            new MustHaveStorageSpaceRule($market->getStorage(), $storageRequired),
            new MustContainCommodityInStorageRule(
                $ship->getStorageComponent(),
                $marketCommodity->getCommodity(),
                $this->getQuantity()
            )
        ];
    }
}
