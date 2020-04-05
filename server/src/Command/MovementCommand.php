<?php

namespace App\Command;

use App\Entity\Ship;
use App\Service\Factories\Command\MovementCommandFactory;
use App\Util\Vector2;

class MovementCommand extends AbstractShipCommand
{
    /** @var Vector2 */
    protected $translation;

    /** @var Vector2 */
    protected $proposedPosition;

    /** @var int */
    protected $fuelCost;

    public function __construct(Ship $ship, Vector2 $translation, int $fuelCost)
    {
        parent::__construct($ship);
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


    public static function getFactoryName(): string
    {
        return MovementCommandFactory::class;
    }
}
