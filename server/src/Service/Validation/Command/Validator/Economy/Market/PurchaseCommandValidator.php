<?php


namespace App\Service\Validation\Command\Validator\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Repository\Join\StoredCommodityRepository;
use App\Service\Validation\Command\Validator\AbstractCommandValidator;
use App\Service\Validation\Rules\Character\MustHaveMoneyRule;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;

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
                $marketCommodity->getMarket()->getStorage(),
                $marketCommodity->getCommodity(),
                $command->getQuantity()
            )
        ];
    }
}
