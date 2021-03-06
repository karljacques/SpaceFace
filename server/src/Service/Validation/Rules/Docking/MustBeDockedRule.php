<?php


namespace App\Service\Validation\Rules\Docking;


use App\Entity\Ship;
use App\Service\Validation\Rules\RuleInterface;

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

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }
}
