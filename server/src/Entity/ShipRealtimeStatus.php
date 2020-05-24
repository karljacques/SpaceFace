<?php


namespace App\Entity;


class ShipRealtimeStatus
{
    protected ?Ship $ship;
    protected float $power = 0;

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    /**
     * @param float $power
     */
    public function setPower(float $power): void
    {
        $this->power = $power;
    }

    public function __sleep()
    {
        return [
            'power'
        ];
    }

    public function isMax(): bool
    {
        return $this->power >= $this->ship->getMaxPower();
    }

    public function getShip(): Ship
    {
        return $this->ship;
    }

    /**
     * @param Ship|null $ship
     */
    public function setShip(Ship $ship): void
    {
        $this->ship = $ship;
    }
}
