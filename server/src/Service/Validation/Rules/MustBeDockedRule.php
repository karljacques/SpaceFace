<?php


namespace App\Service\Validation\Rules;


use App\Entity\Ship;

class MustBeDockedRule implements RuleInterface
{
    private Ship $ship;

    public function __construct(Ship $ship)
    {
        $this->ship = $ship;
    }

    public function getViolationMessage(): string
    {
        return 'Must be docked';
    }

    public function validate(): bool
    {
        return $this->ship->isDocked();
    }
}
