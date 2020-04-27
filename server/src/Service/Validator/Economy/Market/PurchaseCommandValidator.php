<?php


namespace App\Service\Validator\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Repository\Join\StoredCommodityRepository;
use App\Service\Validator\AbstractCommandValidator;

class PurchaseCommandValidator extends AbstractCommandValidator
{
    protected StoredCommodityRepository $storedCommodityRepository;

    public function __construct(StoredCommodityRepository $storedCommodityRepository)
    {
        $this->storedCommodityRepository = $storedCommodityRepository;
    }

    protected function runValidation(CommandInterface $command)
    {
        if (!$command instanceof PurchaseCommand) {
            throw new UnexpectedCommandException($command, PurchaseCommand::class);
        }

        $ship = $command->getShip();
        $marketCommodity = $command->getMarketCommodity();

        if (!$this->isDockedAt($ship, $marketCommodity->getMarket()->getDockable())) {
            $this->addViolation('You are not docked at this market');
        }

        if ($ship->getOwner()->getMoney() < $command->getCost()) {
            $this->addViolation('You do not have enough money for this transaction');
        }

        $storageRequired = $marketCommodity->getCommodity()->getSize() * $command->getQuantity();

        if ($ship->getStorageComponent()->getFreeCapacity() < $storageRequired) {
            $this->addViolation('You do not have enough storage space');
        }

        // Protect the violations below as they have protected information
        if ($this->hasViolations()) {
            return;
        }

        // Check that the market has enough
        if (!$this->storedCommodityRepository->doesStorageContainCommodity(
            $marketCommodity->getMarket()->getStorage(),
            $marketCommodity->getCommodity(),
            $command->getQuantity())) {
            $this->addViolation('Market does not have enough');
        }
    }
}
