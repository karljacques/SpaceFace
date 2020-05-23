<?php


namespace App\Service;


use App\Entity\Ship;
use App\Entity\ShipRealtimeStatus;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class ShipStatusCache
{
    private CacheItemPoolInterface $pool;

    public function __construct(CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }

    /**
     * @param Ship $ship
     * @return CacheItemInterface<ShipRealtimeStatus>
     * @throws InvalidArgumentException
     */
    public function getShipStatus(Ship $ship): CacheItemInterface
    {
        $key = sprintf("ship_%s_status", $ship->getId());

        $item = $this->pool->getItem($key);

        if ($item->isHit()) {
            $status = $item->get();
            $status->setShip($ship);

            return $item;
        }

        $status = new ShipRealtimeStatus();

        $status->setPower($ship->getMaxPower());
        $status->setShip($ship);

        $item->set($status);
        return $item;
    }

    public function persist(CacheItemInterface $item)
    {
        /** @var ShipRealtimeStatus $status */
        $status = $item->get();
        if ($status->isMax()) {
            $key = sprintf("ship_%s_status", $status->getShip()->getId());

            $this->pool->deleteItem($key);
        } else {
            $this->pool->save($item);
        }
    }


}
