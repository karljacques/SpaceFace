<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustBeDockedRule;

class UndockCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        $ship->setDockedAt(null);
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        return [
            new MustBeDockedRule($ship)
        ];
    }
}
