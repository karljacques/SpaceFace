<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;

class UndockCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        $ship->setDockedAt(null);

        $status = $this->getRealtimeStatus($ship);

        $status->applyCooldown(2)
            ->usePower(100);

        $this->persistRealtimeStatus($status);
    }
}
