<?php


namespace App\Service\Validation\Rules\Docking;


use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Validation\Rules\RuleInterface;

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

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }

    /**
     * @return Dockable
     */
    public function getDockable(): Dockable
    {
        return $this->dockable;
    }


}
