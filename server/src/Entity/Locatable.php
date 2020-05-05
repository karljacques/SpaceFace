<?php


namespace App\Entity;


use App\Util\Location;

interface Locatable
{
    public function getLocation(): Location;
}
