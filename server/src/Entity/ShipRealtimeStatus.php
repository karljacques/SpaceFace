<?php


namespace App\Entity;


class ShipRealtimeStatus
{
    protected ?Ship $ship;
    protected int $power = 0;

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power): void
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
        return $this->power === $this->ship->getMaxPower();
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
