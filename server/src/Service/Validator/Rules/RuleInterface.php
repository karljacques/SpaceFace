<?php


namespace App\Service\Validator\Rules;


interface RuleInterface
{
    public function getViolationMessage(): string;

    public function validate(): bool;
}
