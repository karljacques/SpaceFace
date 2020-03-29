<?php

namespace App\Service\Calculators;

use App\Util\Location;

interface MovementCostCalculatorInterface
{
    public function calculateFuelCost(Location $currentLocation, Location $target): int;
}
