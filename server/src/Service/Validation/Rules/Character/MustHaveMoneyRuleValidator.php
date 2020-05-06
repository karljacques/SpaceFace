<?php


namespace App\Service\Validation\Rules\Character;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHaveMoneyRuleValidator implements RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHaveMoneyRule) {
            throw new UnexpectedTypeException($rule, MustHaveMoneyRule::class);
        }

        return $rule->getCharacter()->getMoney() >= $rule->getRequiredMoney();
    }
}
