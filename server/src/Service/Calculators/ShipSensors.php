<?php


namespace App\Service\Calculators;


use App\Entity\Ship;
use App\Repository\DockableRepository;
use App\Repository\JumpNodeRepository;
use App\Repository\SectorRepository;
use App\Util\BoundingBox;
use App\Util\Vector2;
use Tightenco\Collect\Support\Collection;

class ShipSensors
{
    protected SectorRepository $sectorRepository;
    protected DockableRepository $dockableRepository;
    protected JumpNodeRepository $jumpNodeRepository;

    public function __construct(
        SectorRepository $sectorRepository,
        DockableRepository $dockableRepository,
        JumpNodeRepository $jumpNodeRepository
    )
    {
        $this->sectorRepository = $sectorRepository;
        $this->dockableRepository = $dockableRepository;
        $this->jumpNodeRepository = $jumpNodeRepository;
    }

    public function getSectorsInRange(Ship $ship): Collection
    {
        $boundingBox = $this->getShipSensorBoundaries($ship);

        return $this->sectorRepository->findWithinBounds($ship->getSystem(), $boundingBox);
    }

    public function getDockablesInRange(Ship $ship): Collection
    {
        $boundingBox = $this->getShipSensorBoundaries($ship);

        return $this->dockableRepository->findWithinBounds($ship->getSystem(), $boundingBox);
    }

    public function getNodesInRange(Ship $ship): Collection
    {
        $boundingBox = $this->getShipSensorBoundaries($ship);

        return $this->jumpNodeRepository->findWithinBounds($ship->getSystem(), $boundingBox);
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
