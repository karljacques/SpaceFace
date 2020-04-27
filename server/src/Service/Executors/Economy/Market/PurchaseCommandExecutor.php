<?php


namespace App\Service\Executors\Economy\Market;


use App\Command\CommandInterface;
use App\Command\Economy\Market\PurchaseCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Executors\AbstractCommandExecutor;
use App\Service\Manipulators\StorageTransferService;
use App\Service\Validator\Economy\Market\PurchaseCommandValidator;

class PurchaseCommandExecutor extends AbstractCommandExecutor
{
    protected StorageTransferService $storageTransferService;

    public function __construct(PurchaseCommandValidator $commandValidator, StorageTransferService $transferService)
    {
        $this->setValidator($commandValidator);
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
}
