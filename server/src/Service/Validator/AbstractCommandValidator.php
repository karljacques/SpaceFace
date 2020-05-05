<?php

namespace App\Service\Validator;

use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Validator\Rules\RuleInterface;

abstract class AbstractCommandValidator
{
    /**
     * @param CommandInterface $command
     * @return RuleInterface[]
     */
    abstract protected function getValidationRules(CommandInterface $command): array;

    /**
     * @param CommandInterface $command
     * @throws UserActionException
     */
    public function validate(CommandInterface $command)
    {
        $rules = $this->getValidationRules($command);

        $violations = [];
        foreach ($rules as $rule) {
            if (!$rule->validate()) {
                $violations[] = new UserActionViolation($rule->getViolationMessage(), []);
            }
        }

        if (count($violations) > 0) {
            throw new UserActionException($violations);
        }
    }
}
