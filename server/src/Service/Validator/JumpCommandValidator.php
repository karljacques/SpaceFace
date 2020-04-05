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

        if (!$ship->getLocation()->equals($node->getEntryLocation())) {
            $this->addViolation('You are not at entry node');
        }
    }
}
