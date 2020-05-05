<?php


namespace App\Service\Validation\Command\Validator;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\MustHaveSameLocationRule;
use App\Service\Validation\Rules\MustNotBeDockedRule;

class DockCommandValidator extends AbstractCommandValidator
{
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
