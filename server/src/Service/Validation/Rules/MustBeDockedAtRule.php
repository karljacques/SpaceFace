<?php


namespace App\Service\Validation\Rules;


use App\Entity\Dockable;
use App\Entity\Ship;

class MustBeDockedAtRule implements RuleInterface
{
    protected Ship $ship;
    protected Dockable $dockable;

    public function __construct(Ship $ship, Dockable $dockable)
    {
        $this->ship = $ship;
        $this->dockable = $dockable;
    }

    public function getViolationMessage(): string
    {
        return 'You are not docked at the target';
    }


    public function validate(): bool
    {
        if (!$this->ship->isDocked()) {
            return false;
        }

        return $this->ship->getDockedAt() === $this->dockable;
    }
}
