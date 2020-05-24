<?php


namespace App\Entity;


class ShipRealtimeStatus
{
    protected ?Ship $ship;

    protected float $lastUpdate = 0;

    protected float $moveCooldownExpires = 0;
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
            'power',
            'moveCooldownExpires',
            'lastUpdate'
        ];
    }

    public function isMax(): bool
    {
        return $this->power >= $this->ship->getMaxPower()
            && $this->getMoveCooldownExpires() < microtime(true);
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

    public static function createFromShip(Ship $ship): ShipRealtimeStatus
    {
        $status = new static();

        $status->setShip($ship);
        $status->setPower($ship->getMaxPower());

        return $status;
    }

    /**
     * @return float
     */
    public function getLastUpdate(): float
    {
        return $this->lastUpdate;
    }

    /**
     * @param float|int $lastUpdate
     */
    public function setLastUpdate($lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return float|int
     */
    public function getMoveCooldownExpires()
    {
        return $this->moveCooldownExpires;
    }

    /**
     * @param float|int $moveCooldownExpires
     */
    public function setMoveCooldownExpires($moveCooldownExpires): void
    {
        $this->moveCooldownExpires = $moveCooldownExpires;
    }


}
