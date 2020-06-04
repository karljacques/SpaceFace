<?php


namespace App\Service\Executors\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\SellCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Manipulators\StorageTransferService;
use App\Service\Validation\Rules\Docking\MustBeDockedAtRule;
use App\Service\Validation\Rules\Storage\MustContainCommodityInStorageRule;
use App\Service\Validation\Rules\Storage\MustHaveStorageSpaceRule;

class SellCommandExecutor extends AbstractCommandExecutor
{
    protected StorageTransferService $storageTransferService;

    public function __construct(StorageTransferService $transferService)
    {
        $this->storageTransferService = $transferService;
    }

    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof SellCommand) {
            throw new UnexpectedCommandException($command, SellCommand::class);
        }

        $ship = $command->getShip();

        $character = $ship->getOwner();
        $character->setMoney($character->getMoney() + $command->getTotalValue());

        $marketCommodity = $command->getMarketCommodity();
        $commodity = $marketCommodity->getCommodity();

        $this->storageTransferService->transferCommodity(
            $commodity,
            $ship->getStorageComponent(),
            $marketCommodity->getMarket()->getStorage(),
            $command->getQuantity()
        );
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof SellCommand) {
            throw new UnexpectedCommandException($command, SellCommand::class);
        }

        $ship = $command->getShip();
        $marketCommodity = $command->getMarketCommodity();
        $market = $marketCommodity->getMarket();
        $storageRequired = $marketCommodity->getCommodity()->getSize() * $command->getQuantity();

        return [
            new MustBeDockedAtRule($ship, $marketCommodity->getMarket()->getDockable()),
            new MustHaveStorageSpaceRule($market->getStorage(), $storageRequired),
            new MustContainCommodityInStorageRule(
                $ship->getStorageComponent(),
                $marketCommodity->getCommodity(),
                $command->getQuantity()
            )
        ];
    }
}
