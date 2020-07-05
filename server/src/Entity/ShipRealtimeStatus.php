<?php


namespace App\Entity;


use LogicException;

class ShipRealtimeStatus
{
    protected ?Ship $ship;

    protected float $lastUpdate = 0;

    protected ?float $moveCooldownExpires = null;
    protected float $power = 0;

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    public function usePower(int $power): self
    {
        $this->power -= $power;

        return $this;
    }

    public function applyCooldown(float $seconds): self
    {
        $this->moveCooldownExpires = microtime(true) + $seconds;

        return $this;
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
            && $this->getMoveCooldownExpires() === null;
    }

    public function getShip(): ?Ship
    {
        if (null === $this->ship) {
            throw new LogicException(
                sprintf('Expected type of property $this->ship to be %s, null returned', Ship::class));
        }
        return $this->ship;
    }

    /**
     * @param Ship $ship
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
     * @return float
     */
    public function getMoveCooldownExpires(): ?float
    {
        return $this->moveCooldownExpires;
    }

    /**
     * @param float|int $moveCooldownExpires
     */
    public function setMoveCooldownExpires(?float $moveCooldownExpires): void
    {
        $this->moveCooldownExpires = $moveCooldownExpires;
    }


}
