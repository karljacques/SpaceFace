<?php

namespace App\Service\Executors;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;

class MovementCommandExecutor extends AbstractCommandExecutor
{
    /**
     * @param CommandInterface $command
     */
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $ship->setLocation($command->getProposedLocation());

        $ship->setFuel($ship->getFuel() - $command->getFuelCost());


        $status = $this->getRealtimeStatus($ship);

        $status->usePower(50)
            ->applyCooldown(0.5);

        $this->persistRealtimeStatus($status);
    }
}
