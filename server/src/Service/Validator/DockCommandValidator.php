<?php


namespace App\Service\Validator;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;

class DockCommandValidator extends AbstractCommandValidator
{
    protected function runValidation(CommandInterface $command)
    {
        if (!$command instanceof DockCommand) {
            throw new UnexpectedCommandException($command, DockCommand::class);
        }

        $ship = $command->getShip();
        $dockable = $command->getDockable();

        if ($ship->isDocked()) {
            $this->addViolation('Already docked');
        }

        if (!$ship->getLocation()->equals($dockable->getLocation())) {
            $this->addViolation('You must be at the same location as the dockable');
        }
    }
}
