<?php


namespace App\Service\DataCollectors;


use App\Entity\Ship;

interface DataCollectorInterface
{
    public function collect(Ship $ship): array;
}
