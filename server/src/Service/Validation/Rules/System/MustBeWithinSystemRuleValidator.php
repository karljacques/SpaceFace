<?php


namespace App\Service\Validation\Rules\System;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustBeWithinSystemRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustBeWithinSystemRule) {
            throw new UnexpectedTypeException($rule, MustBeWithinSystemRule::class);
        }

        $system = $rule->getLocation()->getSystem();

        return $system->getBoundingBox()->containsPoint($rule->getLocation()->getVector());
    }
}
