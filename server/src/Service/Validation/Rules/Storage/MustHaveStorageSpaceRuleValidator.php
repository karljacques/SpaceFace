<?php


namespace App\Service\Validation\Rules\Storage;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHaveStorageSpaceRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHaveStorageSpaceRule) {
            throw new UnexpectedTypeException($rule, MustHaveStorageSpaceRule::class);
        }

        return $rule->getStorage()->getFreeCapacity() >= $rule->getStorageRequired();
    }
}
