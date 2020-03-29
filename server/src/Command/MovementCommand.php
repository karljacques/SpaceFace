<?php

namespace App\Command;

use App\Entity\Ship;
use App\Util\Location;
use App\Util\Vector2;

class MovementCommand implements CommandInterface
{
    /** @var Vector2 */
    protected $translation;

    /** @var Vector2 */
    protected $proposedPosition;

    /**  @var Ship */
    protected $ship;

    /** @var int */
    protected $fuelCost;

    public function __construct(Ship $ship, Vector2 $translation, int $fuelCost)
    {
        $this->ship = $ship;
        $this->translation = $translation;

        $this->proposedPosition = $ship->getVector()->add($translation);

        $this->fuelCost = $fuelCost;
    }

    /**
     * @return Vector2
     */
    public function getTranslation(): Vector2
    {
        return $this->translation;
    }

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }

    /**
     * @return Vector2
     */
    public function getProposedPosition(): Vector2
    {
        return $this->proposedPosition;
    }

    /**
     * @return int
     */
    public function getFuelCost():int
    {
        return $this->fuelCost;
    }


}
