<?php


namespace App\Service\Infrastructure;


use App\Messenger\Message\UserSpecificMessage;
use App\Repository\ShipRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TickManager
{
    private MessageBusInterface $bus;
    /** Delete Me **/
    private CacheItemPoolInterface $cache;
    /** Delete Me **/
    private ShipRepository $shipRepository;

    public function __construct(
        MessageBusInterface $bus,
        ShipRepository $shipRepository,
        CacheItemPoolInterface $cache
    )
    {
        $this->bus = $bus;
        $this->cache = $cache;
        $this->shipRepository = $shipRepository;
    }

    public function tick()
    {
        $ships = $this->shipRepository->findAll();

        foreach ($ships as $ship) {
            $shipKey = sprintf('ship_%s_power', $ship->getId());

            $cacheItem = $this->cache->getItem($shipKey);

            if (!$cacheItem->isHit()) {
                continue;
            }

            $power = $cacheItem->get();

            $power = $power + 10;

            if ($power >= $ship->getMaxPower()) {
                $power = $ship->getMaxPower();
                $this->cache->deleteItem($shipKey);
            } else {
                $cacheItem->set($power);
                $this->cache->save($cacheItem);
            }

            $this->bus->dispatch(new UserSpecificMessage($ship->getOwner()->getUser(), [
                'power' => $power
            ]));
        }

    }
}
