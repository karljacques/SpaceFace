<?php

namespace App\Service\Executors;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\ShipRealtimeStatusService;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHaveFuelRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;

class MovementCommandExecutor extends AbstractCommandExecutor
{
    private ShipRealtimeStatusService $statusService;

    public function __construct(ShipRealtimeStatusService $statusService)
    {
        $this->statusService = $statusService;
    }

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


        $status = $this->statusService->getShipStatus($ship);

        $status->setPower($status->getPower() - 100);
        $status->setMoveCooldownExpires(microtime(true) + 1);

        $this->statusService->persist($status);
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
            new MustHavePowerRule($ship, 100),
            new MustNotBeInCooldownRule($ship)
        ];
    }
}
