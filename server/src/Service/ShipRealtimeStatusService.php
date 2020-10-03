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
     * @return ShipRealtimeStatus
     */
    public function getShipStatus(Ship $ship): ShipRealtimeStatus
    {
        try {
            $key = $this->getCacheKeyForShip($ship);
            $item = $this->pool->getItem($key);

            if ($item->isHit()) {
                $status = $item->get();
                $status->setShip($ship);

                return $status;
            }

            return ShipRealtimeStatus::createFromShip($ship);
        } catch (InvalidArgumentException $e) {
            throw new LogicException('Invalid key supplied to cache');
        }
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
