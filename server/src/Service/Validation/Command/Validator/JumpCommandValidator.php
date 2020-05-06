<?php


namespace App\Service\Validation\Command\Validator;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;

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
