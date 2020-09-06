<?php

namespace App\Command;

use App\Entity\Ship;
use App\Service\Factories\Command\MovementCommandFactory;
use App\Util\HexVector;
use App\Util\Location;

class MovementCommand extends AbstractShipCommand
{
    /** @var HexVector */
    protected $translation;

    /** @var HexVector */
    protected $proposedPosition;

    /** @var int */
    protected $fuelCost;

    public function __construct(Ship $ship, HexVector $translation, int $fuelCost)
    {
        parent::__construct($ship);
        $this->translation = $translation;

        $this->proposedPosition = $ship->getVector()->add($translation);

        $this->fuelCost = $fuelCost;
    }

    /**
     * @return HexVector
     */
    public function getTranslation(): HexVector
    {
        return $this->translation;
    }

    /**
     * @return Location
     */
    public function getProposedLocation(): Location
    {
        return new Location($this->ship->getSystem(), $this->proposedPosition);
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
