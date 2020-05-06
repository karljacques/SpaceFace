<?php


namespace App\Service\Validation\Rules;


interface RuleValidatorInterface
{
    public function validate(RuleInterface $rule): bool;
}
