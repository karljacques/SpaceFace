<?php

namespace App\Command;

use App\Entity\Ship;
use App\Util\Vector2;

class MovementCommand implements CommandInterface
{
    /** @var Vector2 */
    protected $translation;

    /** @var Vector2 */
    protected $proposedPosition;

    /**  @var Ship */
    protected $ship;


    public function __construct(Ship $ship, Vector2 $translation)
    {
        $this->ship = $ship;
        $this->translation = $translation;

        $this->proposedPosition = $ship->getVector()->add($translation);
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
}
