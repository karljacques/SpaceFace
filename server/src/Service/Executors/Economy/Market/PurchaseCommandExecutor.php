<?php


namespace App\Service\Executors\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Manipulators\StorageTransferService;
use App\Service\Validation\Command\Validator\Economy\Market\PurchaseCommandValidator;
use App\Service\Validation\Rules\Character\MustHaveMoneyRule;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;

class PurchaseCommandExecutor extends AbstractCommandExecutor
{
    protected StorageTransferService $storageTransferService;

    public function __construct(StorageTransferService $transferService)
    {
        $this->storageTransferService = $transferService;
    }

    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof PurchaseCommand) {
            throw new UnexpectedCommandException($command, PurchaseCommand::class);
        }

        $ship = $command->getShip();

        $character = $ship->getOwner();
        $character->setMoney($character->getMoney() - $command->getCost());

        $marketCommodity = $command->getMarketCommodity();
        $commodity = $marketCommodity->getCommodity();

        $this->storageTransferService->transferCommodity(
            $commodity,
            $marketCommodity->getMarket()->getStorage(),
            $ship->getStorageComponent(),
            $command->getQuantity()
        );
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
