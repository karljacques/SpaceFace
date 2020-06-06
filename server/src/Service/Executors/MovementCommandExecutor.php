<?php

namespace App\Service\Executors;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHaveFuelRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;

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

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $fuelRequired = $command->getFuelCost();


        return [
            new MustNotBeDockedRule($ship),
            new MustHaveFuelRule($ship, $fuelRequired),
            new MustBeWithinSystemRule($command->getProposedLocation()),
            new MustHavePowerRule($ship, 50),
            new MustNotBeInCooldownRule($ship)
        ];
    }
}
