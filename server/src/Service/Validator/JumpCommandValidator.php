<?php


namespace App\Service\Validator;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validator\Rules\MustHaveSameLocationRule;
use App\Service\Validator\Rules\MustNotBeDockedRule;

class JumpCommandValidator extends AbstractCommandValidator
{
    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $ship = $command->getShip();
        $node = $command->getNode();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveSameLocationRule($ship, $node)
        ];
    }
}
