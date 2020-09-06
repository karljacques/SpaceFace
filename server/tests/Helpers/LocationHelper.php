<?php


namespace App\Tests\Helpers;


use App\Util\HexVector;
use App\Util\Location;

class LocationHelper
{
    /**
     * @param Location $location
     * @return Location
     */
    public static function offsetLocation(Location $location): Location
    {
        return new Location(
            $location->getSystem(),
            $location->getVector()
                ->add(new HexVector(1, 0))
        );
    }
}
