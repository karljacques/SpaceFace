<?php


namespace App\Tests\Helpers;


use App\Util\Location;
use App\Util\Vector2;

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
                ->add(new Vector2(1, 0))
        );
    }
}
