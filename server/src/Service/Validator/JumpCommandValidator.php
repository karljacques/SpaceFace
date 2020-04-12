<?php


namespace App\Service\Validator;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;

class JumpCommandValidator extends AbstractCommandValidator
{
    protected function runValidation(CommandInterface $command)
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $ship = $command->getShip();
        $node = $command->getNode();

        if ($ship->isDocked()) {
            $this->addViolation('You cannot jump while docked');
        }

        if (!$ship->getLocation()->equals($node->getLocation())) {
            $this->addViolation('You are not at entry node');
        }
    }
}
