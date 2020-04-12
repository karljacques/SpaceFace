<?php


namespace App\Service\Validator;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;

class UndockCommandValidator extends AbstractCommandValidator
{

    protected function runValidation(CommandInterface $command)
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        if (!$ship->isDocked()) {
            $this->addViolation('Ship not docked');
        }
    }
}
