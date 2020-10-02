<?php


namespace App\Command\Economy\Market;


use App\Command\AbstractShipCommand;
use App\Entity\Join\MarketCommodity;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;
use LogicException;

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
        $buy = $this->marketCommodity->getBuy();

        if (null === $buy) {
            throw new LogicException('MarketCommodity has no buy value');
        }

        return $buy * $this->getQuantity();
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

        $rules = [
            new MustHaveStorageSpaceRule($market->getStorage(), $storageRequired),
            new MustContainCommodityInStorageRule(
                $ship->getStorageComponent(),
                $marketCommodity->getCommodity(),
                $this->getQuantity()
            )
        ];

        $marketDockable = $marketCommodity->getMarket()->getDockable();

        if (null !== $marketDockable) {
            $rules[] = new MustBeDockedAtRule($ship, $marketDockable);
        }

        return $rules;
    }
}
