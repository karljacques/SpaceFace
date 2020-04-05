<?php


namespace App\Command;


use App\Entity\Ship;

abstract class AbstractShipCommand implements CommandInterface
{
    /**  @var Ship */
    protected $ship;

    public function __construct(Ship $ship)
    {
        $this->ship = $ship;
    }

    public function getShip(): Ship
    {
        return $this->ship;
    }
}
