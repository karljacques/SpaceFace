<?php


namespace App\Service\Calculators;


use App\Entity\Ship;
use App\Repository\SectorRepository;
use App\Util\BoundingBox;
use App\Util\Vector2;
use Tightenco\Collect\Support\Collection;

class ShipSensors
{
    protected SectorRepository $sectorRepository;

    public function __construct(SectorRepository $sectorRepository)
    {
        $this->sectorRepository = $sectorRepository;
    }

    public function getSectorsInRange(Ship $ship): Collection
    {
        $boundingBox = $this->getShipSensorBoundaries($ship);

        return $this->sectorRepository->getSectorsWithinBounds($ship->getSystem(), $boundingBox);
    }

    protected function getShipSensorBoundaries(Ship $ship): BoundingBox
    {
        $offset = 2;

        $delta = new Vector2($offset, $offset);

        return new BoundingBox(
            $ship->getVector()->subtract($delta),
            $ship->getVector()->add($delta)
        );
    }
}
