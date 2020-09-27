<?php


namespace App\Command;


use App\Service\Validation\Rules\RuleInterface;

interface CommandInterface
{
    /** @return RuleInterface[] */
    public function getValidationRules(): array;
}
