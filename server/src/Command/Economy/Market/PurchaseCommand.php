<?php


namespace App\Command\Economy\Market;


use App\Command\AbstractShipCommand;
use App\Entity\Join\MarketCommodity;
use App\Entity\Ship;
use App\Service\Validation\Rules\Character\MustHaveMoneyRule;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;

class PurchaseCommand extends AbstractShipCommand
{
    protected MarketCommodity $marketCommodity;
    protected int $quantity;

    public function __construct(Ship $ship, MarketCommodity $marketCommodity, int $quantity)
    {
        parent::__construct($ship);

        $this->marketCommodity = $marketCommodity;
        $this->quantity = $quantity;
    }

    /**
     * @return MarketCommodity
     */
    public function getMarketCommodity(): MarketCommodity
    {
        return $this->marketCommodity;
    }

    public function getTotalValue(): int
    {
        return $this->marketCommodity->getSell() * $this->getQuantity();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getValidationRules(): array
    {
        $ship = $this->getShip();
        $marketCommodity = $this->getMarketCommodity();
        $storageRequired = $marketCommodity->getCommodity()->getSize() * $this->getQuantity();

        return [
            new MustBeDockedAtRule($ship, $marketCommodity->getMarket()->getDockable()),
            new MustHaveMoneyRule($ship->getOwner(), $this->getTotalValue()),
            new MustHaveStorageSpaceRule($ship->getStorageComponent(), $storageRequired),
            new MustContainCommodityInStorageRule(
                $marketCommodity->getMarket()->getStorage(),
                $marketCommodity->getCommodity(),
                $this->getQuantity()
            )
        ];
    }
}
