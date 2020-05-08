<?php


namespace App\Command\Economy\Market;


use App\Command\AbstractShipCommand;
use App\Entity\Join\MarketCommodity;
use App\Entity\Ship;
use App\Service\Factories\Command\Economy\Market\SellCommandFactory;

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

    public static function getFactoryName(): string
    {
        return SellCommandFactory::class;
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
        return $this->marketCommodity->getBuy() * $this->getQuantity();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
