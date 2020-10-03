<?php


namespace App\Service\Infrastructure;


use App\Messenger\Message\UserSpecificMessage;
use App\Repository\Realtime\ShipRealtimeStatusRepositoryInterface;
use App\Repository\ShipRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class TickManager
{
    private MessageBusInterface $bus;
    private ShipRealtimeStatusRepositoryInterface $cache;
    private ShipRepository $shipRepository;

    public function __construct(
        MessageBusInterface $bus,
        ShipRepository $shipRepository,
        ShipRealtimeStatusRepositoryInterface $cache
    )
    {
        $this->bus = $bus;
        $this->cache = $cache;
        $this->shipRepository = $shipRepository;
    }

    public function tick(): void
    {
        $ships = $this->shipRepository->findAll();

        foreach ($ships as $ship) {
            $status = $this->cache->findOneByShip($ship);

            $elapsedTime = microtime(true) - $status->getLastUpdate();

            $status->setPower(min($status->getPower() + (20 * $elapsedTime), $ship->getMaxPower()));

            if ($status->getMoveCooldownExpires() && ($status->getMoveCooldownExpires() <= microtime(true))) {
                $this->bus->dispatch(new UserSpecificMessage($ship->getOwner()->getUser(), [
                    'event' => 'cooldownExpired'
                ]));

                $status->setMoveCooldownExpires(null);
            }
            $this->cache->persist($status);
            $this->bus->dispatch(new UserSpecificMessage($ship->getOwner()->getUser(), [
                'event' => 'update',
                'power' => $status->getPower()
            ]));
        }

    }
}
