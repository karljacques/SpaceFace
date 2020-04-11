<?php


namespace App\Service\DataCollectors;


use App\Entity\Ship;

class PlayerDataCollector implements DataCollectorInterface
{
    public function collect(Ship $ship): array
    {
        return ['ship' => $ship];
    }
}
