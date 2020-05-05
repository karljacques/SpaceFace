<?php

namespace App\Service\Validation\Command\Validator;

use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Validation\Command\UserActionViolation;
use App\Service\Validation\Rules\RuleInterface;

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
