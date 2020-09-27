<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;

class DockCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof DockCommand) {
            throw new UnexpectedCommandException($command, DockCommand::class);
        }

        $ship = $command->getShip();
        $dockable = $command->getDockable();

        $ship->setDockedAt($dockable);

        $status = $this->getRealtimeStatus($ship);
        $status->usePower(50)
            ->applyCooldown(1);

        $this->persistRealtimeStatus($status);
    }
}
