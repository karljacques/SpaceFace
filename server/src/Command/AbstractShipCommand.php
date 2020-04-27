<?php


namespace App\Command;


use App\Entity\Ship;

abstract class AbstractShipCommand implements CommandInterface
{
    protected Ship $ship;

    public function __construct(Ship $ship)
    {
        $this->ship = $ship;
    }

    public function getShip(): Ship
    {
        return $this->ship;
    }
}
