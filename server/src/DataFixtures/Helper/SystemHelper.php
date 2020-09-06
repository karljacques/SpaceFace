<?php


namespace App\DataFixtures\Helper;


use App\Entity\System;
use App\Util\HexVector;
use App\Util\Location;
use Faker\Factory;

class SystemHelper
{
    public static function randomLocation(System $system): Location
    {
        $faker = Factory::create();

        return new Location(
            $system,
            new HexVector(
                $faker->numberBetween(1, $system->getSizeX()),
                $faker->numberBetween(1, $system->getSizeY()))
        );
    }
}
