<?php

namespace App\Service\Validation\Command\Validator;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Calculators\MovementCostCalculatorInterface;
use App\Service\Validation\Rules\MustBeWithinSystemRule;
use App\Service\Validation\Rules\MustHaveFuelRule;
use App\Service\Validation\Rules\MustNotBeDockedRule;

class MovementCommandValidator extends AbstractCommandValidator
{
    private $movementCostCalculator;

    public function __construct(MovementCostCalculatorInterface $movementCostCalculator)
    {
        $this->movementCostCalculator = $movementCostCalculator;
    }

    function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $fuelRequired = $command->getFuelCost();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveFuelRule($ship, $fuelRequired),
            new MustBeWithinSystemRule($command->getProposedLocation())
        ];
    }
}
