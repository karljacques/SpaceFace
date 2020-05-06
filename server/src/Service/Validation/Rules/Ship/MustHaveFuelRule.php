<?php


namespace App\Service\Validation\Rules\Ship;


use App\Entity\Ship;
use App\Service\Validation\Rules\RuleInterface;

class MustHaveFuelRule implements RuleInterface
{
    /**
     * @var Ship
     */
    private Ship $ship;
    /**
     * @var int
     */
    private int $required;

    public function __construct(Ship $ship, int $required)
    {
        $this->ship = $ship;
        $this->required = $required;
    }

    public function getViolationMessage(): string
    {
        return 'Not enough fuel';
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
    public function getRequired(): int
    {
        return $this->required;
    }
}
