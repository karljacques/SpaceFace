<?php


namespace App\Service\Validation\Rules\Docking;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustBeDockedRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustBeDockedRule) {
            throw new UnexpectedTypeException($rule, MustBeDockedRule::class);
        }

        return $rule->getShip()->isDocked();
    }
}
