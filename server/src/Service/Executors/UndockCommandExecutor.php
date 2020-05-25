<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

class UndockCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        $ship->setDockedAt(null);

        $status = $this->getRealtimeStatus($ship);

        $status->applyCooldown(2)
            ->usePower(100);

        $this->persistRealtimeStatus($status);
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        return [
            new MustBeDockedRule($ship),
            new MustNotBeInCooldownRule($ship),
            new MustHavePowerRule($ship, 100),
        ];
    }
}
