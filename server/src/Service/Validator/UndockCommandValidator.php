<?php


namespace App\Service\Validator;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validator\Rules\MustBeDockedRule;

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
