<?php


namespace App\Service\DataCollectors;


use App\Entity\Ship;
use App\Repository\DockableRepository;
use App\Repository\JumpNodeRepository;
use App\Repository\SectorRepository;

class SectorDataCollector implements DataCollectorInterface
{
    protected JumpNodeRepository $jumpNodeRepository;
    protected SectorRepository $sectorRepository;
    protected DockableRepository $dockableRepository;

    public function __construct(
        JumpNodeRepository $jumpNodeRepository,
        SectorRepository $sectorRepository,
        DockableRepository $dockableRepository
    )
    {
        $this->jumpNodeRepository = $jumpNodeRepository;
        $this->sectorRepository = $sectorRepository;
        $this->dockableRepository = $dockableRepository;
    }

    public function collect(Ship $ship): array
    {
        $entryNodes = $this->jumpNodeRepository->findByLocation($ship->getLocation());
        $sector = $this->sectorRepository->findByLocation($ship->getLocation());
        $dockables = $this->dockableRepository->findByLocation($ship->getLocation());

        return [
            'entryNodes' => $entryNodes,
            'sector' => $sector,
            'dockables' => $dockables
        ];
    }
}
