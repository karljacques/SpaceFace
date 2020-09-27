<?php


namespace App\Command;


use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

class DockCommand extends AbstractShipCommand
{
    protected Dockable $dockable;

    public function __construct(Ship $ship, Dockable $dockable)
    {
        $this->dockable = $dockable;

        parent::__construct($ship);
    }


    /**
     * @return Dockable
     */
    public function getDockable(): Dockable
    {
        return $this->dockable;
    }

    public function getValidationRules(): array
    {
        $ship = $this->getShip();
        $dockable = $this->getDockable();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveSameLocationRule($ship, $dockable),
            new MustNotBeInCooldownRule($ship),
            new MustHavePowerRule($ship, 50)
        ];
    }
}
