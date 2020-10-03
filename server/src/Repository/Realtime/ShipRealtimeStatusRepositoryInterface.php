<?php

namespace App\Repository\Realtime;

use App\Entity\Ship;
use App\Entity\ShipRealtimeStatus;

interface ShipRealtimeStatusRepositoryInterface
{
    /**
     * @param Ship $ship
     * @return ShipRealtimeStatus
     */
    public function findOneByShip(Ship $ship): ShipRealtimeStatus;

    public function persist(ShipRealtimeStatus $status): void;
}
