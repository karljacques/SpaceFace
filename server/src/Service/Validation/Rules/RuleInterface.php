<?php


namespace App\Service\Validation\Rules;


interface RuleInterface
{
    public function getViolationMessage(): string;

    public function validate(): bool;
}
