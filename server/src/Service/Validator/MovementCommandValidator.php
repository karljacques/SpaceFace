<?php

namespace App\Service\Validator;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MovementCommandValidator extends AbstractCommandValidator
{
    function runValidation(CommandInterface $command)
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $system = $ship->getSystem();

        if (!$system->getBoundingBox()->containsPoint($command->getProposedPosition())) {
            $this->addViolation('Proposed movement is out of system bounds',
                [
                    'current_position' => $ship->getVector(),
                    'delta' => $command->getTranslation(),
                    'proposed_position' => $command->getProposedPosition()
                ]);
        }
    }
}
