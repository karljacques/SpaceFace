<?php


namespace App\Service\Infrastructure;


use App\Entity\ShipRealtimeStatus;
use App\Messenger\Message\UserSpecificMessage;
use App\Repository\ShipRepository;
use App\Service\ShipStatusCache;
use Symfony\Component\Messenger\MessageBusInterface;

class TickManager
{
    private MessageBusInterface $bus;
    private ShipStatusCache $cache;
    private ShipRepository $shipRepository;

    public function __construct(
        MessageBusInterface $bus,
        ShipRepository $shipRepository,
        ShipStatusCache $cache
    )
    {
        $this->bus = $bus;
        $this->cache = $cache;
        $this->shipRepository = $shipRepository;
    }

    public function tick(int $milliseconds)
    {
        $ships = $this->shipRepository->findAll();

        foreach ($ships as $ship) {
            $cacheItem = $this->cache->getShipStatus($ship);

            if (!$cacheItem->isHit()) {
                continue;
            }

            /** @var ShipRealtimeStatus $status */
            $status = $cacheItem->get();

            $status->setPower(min($status->getPower() + (0.01 * $milliseconds), $ship->getMaxPower()));

            $this->cache->persist($cacheItem);
            $this->bus->dispatch(new UserSpecificMessage($ship->getOwner()->getUser(), [
                'event' => 'update',
                'power' => $status->getPower()
            ]));
        }

    }
}
