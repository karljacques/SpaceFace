<?php


namespace App\Service\Validation\Rules\Ship;


use App\Entity\Ship;
use App\Service\Validation\Rules\RuleInterface;

class MustHavePowerRule implements RuleInterface
{
    private Ship $ship;
    private int $requiredPower;

    public function __construct(Ship $ship, int $requiredPower)
    {
        $this->ship = $ship;
        $this->requiredPower = $requiredPower;
    }

    public function getViolationMessage(): string
    {
        return 'Not enough power';
    }

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }

    /**
     * @return int
     */
    public function getRequiredPower(): int
    {
        return $this->requiredPower;
    }
}
