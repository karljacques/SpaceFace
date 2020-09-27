<?php


namespace App\Service\Executors\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\SellCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Manipulators\StorageTransferService;

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
}
