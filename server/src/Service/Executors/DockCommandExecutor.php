<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

class DockCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof DockCommand) {
            throw new UnexpectedCommandException($command, DockCommand::class);
        }

        $ship = $command->getShip();
        $dockable = $command->getDockable();

        $ship->setDockedAt($dockable);

        $status = $this->getRealtimeStatus($ship);
        $status->usePower(50)
            ->applyCooldown(1);

        $this->persistRealtimeStatus($status);
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof DockCommand) {
            throw new UnexpectedCommandException($command, DockCommand::class);
        }

        $ship = $command->getShip();
        $dockable = $command->getDockable();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveSameLocationRule($ship, $dockable),
            new MustNotBeInCooldownRule($ship),
            new MustHavePowerRule($ship, 50)
        ];
    }
}
