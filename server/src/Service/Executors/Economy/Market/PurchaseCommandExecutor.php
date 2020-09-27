<?php


namespace App\Service\Executors\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Manipulators\StorageTransferService;

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
        $character->setMoney($character->getMoney() - $command->getTotalValue());

        $marketCommodity = $command->getMarketCommodity();
        $commodity = $marketCommodity->getCommodity();

        $this->storageTransferService->transferCommodity(
            $commodity,
            $marketCommodity->getMarket()->getStorage(),
            $ship->getStorageComponent(),
            $command->getQuantity()
        );
    }
}
