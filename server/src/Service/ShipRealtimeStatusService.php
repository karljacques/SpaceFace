<?php


namespace App\Service;


use App\Entity\Ship;
use App\Entity\ShipRealtimeStatus;
use LogicException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class ShipRealtimeStatusService
{
    private CacheItemPoolInterface $pool;

    public function __construct(CacheItemPoolInterface $pool)
    {
        $this->pool = $pool;
    }

    /**
     * @param Ship $ship
     * @param bool $createIfNull
     * @return ShipRealtimeStatus
     */
    public function getShipStatus(Ship $ship, bool $createIfNull = true): ?ShipRealtimeStatus
    {
        $key = $this->getCacheKeyForShip($ship);

        try {
            $item = $this->pool->getItem($key);
        } catch (InvalidArgumentException $e) {
            return $createIfNull ? ShipRealtimeStatus::createFromShip($ship) : null;
        }

        if ($item->isHit()) {
            $status = $item->get();
            $status->setShip($ship);

            return $status;
        }

        return $createIfNull ? ShipRealtimeStatus::createFromShip($ship) : null;
    }


    public function persist(ShipRealtimeStatus $status): void
    {
        $key = $this->getCacheKeyForShip($status->getShip());

        $status->setLastUpdate(microtime(true));

        try {
            if ($this->pool->hasItem($key)) {
                if ($status->isMax()) {
                    $this->pool->deleteItem($key);
                } else {
                    $item = $this->pool->getItem($key);
                    $item->set($status);
                    $this->pool->save($item);
                }
            } else {
                if (!$status->isMax()) {
                    $item = $this->pool->getItem($key);
                    $item->set($status);
                    $this->pool->save($item);
                }
            }
        } catch (InvalidArgumentException $e) {
            throw new LogicException('Invalid key passed');
        }

    }

    /**
     * @param Ship $ship
     * @return string
     */
    protected function getCacheKeyForShip(Ship $ship): string
    {
        return sprintf("ship_%s_status", $ship->getId());
    }
}
