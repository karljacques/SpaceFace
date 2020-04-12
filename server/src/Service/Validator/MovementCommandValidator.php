<?php

namespace App\Service\Validator;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Calculators\MovementCostCalculatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MovementCommandValidator extends AbstractCommandValidator
{
    private $movementCostCalculator;

    public function __construct(MovementCostCalculatorInterface $movementCostCalculator)
    {
        $this->movementCostCalculator = $movementCostCalculator;
    }

    function runValidation(CommandInterface $command)
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $system = $ship->getSystem();

        if ($ship->isDocked()) {
            $this->addViolation('You cannot move while docked');
        }

        if (!$system->getBoundingBox()->containsPoint($command->getProposedPosition())) {
            $this->addViolation('Proposed movement is out of system bounds',
                [
                    'current_position' => $ship->getVector(),
                    'delta' => $command->getTranslation(),
                    'proposed_position' => $command->getProposedPosition()
                ]);
        }

        $fuelRequired = $command->getFuelCost();

        if ($ship->getFuel() < $fuelRequired) {
            $this->addViolation('Not enough fuel',
                [
                    'fuel' => $ship->getFuel(),
                    'fuel_required' => $fuelRequired
                ]);
        }
    }
}
