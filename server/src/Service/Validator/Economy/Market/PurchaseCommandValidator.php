<?php


namespace App\Service\Validator\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Repository\Join\StoredCommodityRepository;
use App\Service\Validator\AbstractCommandValidator;
use App\Service\Validator\Rules\MustBeDockedAtRule;
use App\Service\Validator\Rules\MustContainCommodityInStorageRule;
use App\Service\Validator\Rules\MustHaveMoneyRule;
use App\Service\Validator\Rules\MustHaveStorageSpaceRule;

class PurchaseCommandValidator extends AbstractCommandValidator
{
    protected StoredCommodityRepository $storedCommodityRepository;

    public function __construct(StoredCommodityRepository $storedCommodityRepository)
    {
        $this->storedCommodityRepository = $storedCommodityRepository;
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof PurchaseCommand) {
            throw new UnexpectedCommandException($command, PurchaseCommand::class);
        }

        $ship = $command->getShip();
        $marketCommodity = $command->getMarketCommodity();
        $storageRequired = $marketCommodity->getCommodity()->getSize() * $command->getQuantity();

        return [
            new MustBeDockedAtRule($ship, $marketCommodity->getMarket()->getDockable()),
            new MustHaveMoneyRule($ship->getOwner(), $command->getCost()),
            new MustHaveStorageSpaceRule($ship->getStorageComponent(), $storageRequired),
            new MustContainCommodityInStorageRule(
                $this->storedCommodityRepository,
                $marketCommodity->getMarket()->getStorage(),
                $marketCommodity->getCommodity(),
                $command->getQuantity()
            )
        ];
    }
}