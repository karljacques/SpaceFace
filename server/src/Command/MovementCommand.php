<?php

namespace App\Command;

use App\Entity\Ship;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Ship\MustHaveFuelRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;
use App\Service\Validation\Rules\System\MustBeWithinSystemRule;
use App\Util\HexVector;
use App\Util\Location;

class MovementCommand extends AbstractShipCommand
{
    protected HexVector $translation;
    protected HexVector $proposedPosition;
    protected int $fuelCost;

    public function __construct(Ship $ship, HexVector $translation, int $fuelCost)
    {
        parent::__construct($ship);
        $this->translation = $translation;

        $this->proposedPosition = $ship->getVector()->add($translation);

        $this->fuelCost = $fuelCost;
    }

    public function getTranslation(): HexVector
    {
        return $this->translation;
    }

    public function getProposedLocation(): Location
    {
        return new Location($this->ship->getSystem(), $this->proposedPosition);
    }

    public function getFuelCost(): int
    {
        return $this->fuelCost;
    }

    public function getValidationRules(): array
    {
        return [
            new MustNotBeDockedRule($this->ship),
            new MustHaveFuelRule($this->ship, $this->fuelCost),
            new MustBeWithinSystemRule($this->getProposedLocation()),
            new MustHavePowerRule($this->ship, 50),
            new MustNotBeInCooldownRule($this->ship)
        ];
    }
}
