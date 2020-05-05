<?php


namespace App\Service\Validation\Rules;


use App\Entity\Ship;

class MustNotBeDockedRule implements RuleInterface
{
    private Ship $ship;

    public function __construct(Ship $ship)
    {
        $this->ship = $ship;
    }

    public function getViolationMessage(): string
    {
        return 'Must not be docked';
    }

    public function validate(): bool
    {
        return false === $this->ship->isDocked();
    }
}
