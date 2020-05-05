<?php


namespace App\Service\Validation\Rules;


use App\Entity\Ship;

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

    public function validate(): bool
    {
        return $this->ship->getFuel() >= $this->required;
    }
}
