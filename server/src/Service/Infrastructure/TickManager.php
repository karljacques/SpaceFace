<?php


namespace App\Service\Infrastructure;


use App\Messenger\Message\UserSpecificMessage;
use App\Repository\ShipRepository;
use App\Service\ShipRealtimeStatusService;
use Symfony\Component\Messenger\MessageBusInterface;

class TickManager
{
    private MessageBusInterface $bus;
    private ShipRealtimeStatusService $cache;
    private ShipRepository $shipRepository;

    public function __construct(
        MessageBusInterface $bus,
        ShipRepository $shipRepository,
        ShipRealtimeStatusService $cache
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
            $status = $this->cache->getShipStatus($ship, false);

            if (null === $status) {
                continue;
            }

            $status->setPower(min($status->getPower() + (0.01 * $milliseconds), $ship->getMaxPower()));

            $this->cache->persist($status);
            $this->bus->dispatch(new UserSpecificMessage($ship->getOwner()->getUser(), [
                'event' => 'update',
                'power' => $status->getPower()
            ]));
        }

    }
}
