<?php


namespace App\Service\Validation\Command\Validator;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\MustBeDockedRule;

class UndockCommandValidator extends AbstractCommandValidator
{
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
