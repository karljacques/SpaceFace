<?php

namespace App\Service\Calculators;

use App\Util\Location;

class MovementCostCalculator implements MovementCostCalculatorInterface
{
    public function calculateFuelCost(Location $currentLocation, Location $target): int
    {
        return 2;
    }
}
