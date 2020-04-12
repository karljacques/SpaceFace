<?php


namespace App\Service\DataCollectors;


use App\Entity\Ship;
use App\Service\Calculators\ShipSensors;

class SystemDataCollector implements DataCollectorInterface
{
    protected ShipSensors $sensors;

    public function __construct(ShipSensors $sensors)
    {
        $this->sensors = $sensors;
    }

    public function collect(Ship $ship): array
    {
        return [
            'sectors' => $this->sensors->getSectorsInRange($ship),
            'dockables' => $this->sensors->getDockablesInRange($ship),
            'entryNodes'=> $this->sensors->getNodesInRange($ship)
        ];
    }
}
