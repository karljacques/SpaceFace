<?php


namespace App\Service\Validation\Rules\Docking;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustNotBeDockedRuleValidator implements RuleValidatorInterface
{

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustNotBeDockedRule) {
            throw new UnexpectedTypeException($rule, MustNotBeDockedRule::class);
        }

        return false === $rule->getShip()->isDocked();
    }
}
