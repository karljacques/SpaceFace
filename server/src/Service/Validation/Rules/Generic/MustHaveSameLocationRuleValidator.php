<?php


namespace App\Service\Validation\Rules\Generic;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHaveSameLocationRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHaveSameLocationRule) {
            throw new UnexpectedTypeException($rule, MustHaveSameLocationRule::class);
        }

        return $rule->getA()->getLocation()->equals($rule->getB()->getLocation());
    }
}
