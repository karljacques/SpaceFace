<?php


namespace App\Service\Validation\Rules\Docking;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustBeDockedAtRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustBeDockedAtRule) {
            throw new UnexpectedTypeException($rule, MustBeDockedAtRule::class);
        }

        if (!$rule->getShip()->isDocked()) {
            return false;
        }

        return $rule->getShip()->getDockedAt() === $rule->getDockable();
    }
}
