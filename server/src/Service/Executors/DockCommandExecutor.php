<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validator\DockCommandValidator;

class DockCommandExecutor extends AbstractCommandExecutor
{
    public function __construct(DockCommandValidator $validator)
    {
        $this->setValidator($validator);
    }

    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof DockCommand) {
            throw new UnexpectedCommandException($command, DockCommand::class);
        }

        $ship = $command->getShip();
        $dockable = $command->getDockable();

        $ship->setDockedAt($dockable);
    }
}
