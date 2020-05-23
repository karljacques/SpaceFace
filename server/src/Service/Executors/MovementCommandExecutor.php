<?php

namespace App\Service\Executors;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\ShipRealtimeStatus;
use App\Exception\UnexpectedCommandException;
use App\Service\ShipStatusCache;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHaveFuelRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;

class MovementCommandExecutor extends AbstractCommandExecutor
{
    private ShipStatusCache $cache;

    public function __construct(ShipStatusCache $cache)
    {
        $this->cache = $cache;
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


        $item = $this->cache->getShipStatus($ship);
        /** @var ShipRealtimeStatus $status */
        $status = $item->get();

        $status->setPower($status->getPower() - 100);
        $this->cache->persist($item);
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
            new MustHavePowerRule($ship, 100)
        ];
    }
}
