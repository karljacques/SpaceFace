<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHaveFuelRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHaveFuelRule) {
            throw new UnexpectedTypeException($rule, MustHaveFuelRule::class);
        }

        return $rule->getShip()->getFuel() >= $rule->getRequired();
    }
}
