<?php


namespace App\Service\Validation\Rules\Ship;


use App\Entity\Ship;
use App\Service\Validation\Rules\RuleInterface;

class MustNotBeInCooldownRule implements RuleInterface
{
    private Ship $ship;

    public function __construct(Ship $ship)
    {
        $this->ship = $ship;
    }

    public function getViolationMessage(): string
    {
        return 'Ship engines are cooling down';
    }

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }


}
