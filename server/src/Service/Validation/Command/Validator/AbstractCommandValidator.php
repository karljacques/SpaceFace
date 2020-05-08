<?php

namespace App\Service\Validation\Command\Validator;

use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Validation\Command\UserActionViolation;
use App\Service\Validation\Rules\RuleInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

abstract class AbstractCommandValidator implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    /**
     * @param CommandInterface $command
     * @return RuleInterface[]
     */
    abstract protected function getValidationRules(CommandInterface $command): array;

    /**
     * @param CommandInterface $command
     *
     * @return void
     * @throws UserActionException
     *
     */
    public function validate(CommandInterface $command): void
    {
        $rules = $this->getValidationRules($command);

        $violations = [];
        foreach ($rules as $rule) {
            $validator = $this->ruleLocator()->getRuleValidator(get_class($rule));

            if (!$validator->validate($rule)) {
                $violations[] = new UserActionViolation($rule->getViolationMessage(), []);
            }
        }

        if (count($violations) > 0) {
            throw new UserActionException($violations);
        }
    }

    public function ruleLocator(): RuleLocator
    {
        return $this->container->get(__METHOD__);
    }
}
