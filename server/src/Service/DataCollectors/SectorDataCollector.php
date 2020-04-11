<?php


namespace App\Service\DataCollectors;


use App\Entity\Ship;
use App\Repository\JumpNodeRepository;
use App\Repository\SectorRepository;

class SectorDataCollector implements DataCollectorInterface
{
    protected JumpNodeRepository $jumpNodeRepository;
    protected SectorRepository $sectorRepository;

    public function __construct(
        JumpNodeRepository $jumpNodeRepository,
        SectorRepository $sectorRepository
    )
    {
        $this->jumpNodeRepository = $jumpNodeRepository;
        $this->sectorRepository = $sectorRepository;
    }

    public function collect(Ship $ship): array
    {
        $entryNodes = $this->jumpNodeRepository->findEntryNodeByLocation($ship->getLocation());

        return [
            'entryNodes' => $entryNodes
        ];
    }
}
