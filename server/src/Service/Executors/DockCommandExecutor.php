<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Command\Validator\DockCommandValidator;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;

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
            new MustHaveSameLocationRule($ship, $dockable)
        ];
    }
}
