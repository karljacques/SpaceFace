<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;

class JumpCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $command->getShip()->setLocation($command->getNode()->getExitLocation());

        $ship = $command->getShip();

        $status = $this->getRealtimeStatus($ship);
        $status->applyCooldown(2)
            ->usePower(500);

        $this->persistRealtimeStatus($status);
    }
}
