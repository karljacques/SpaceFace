<?php


namespace App\Controller;


use App\Entity\Ship;
use App\Entity\User;
use App\Service\DataCollectors\DataCollectorInterface;
use App\Service\DataCollectors\PlayerDataCollector;
use App\Service\DataCollectors\SectorDataCollector;
use App\Service\DataCollectors\SystemDataCollector;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractGameController extends AbstractController
{
    public function information(array $keys, Ship $ship): array
    {
        $data = [];

        foreach ($keys as $collectorClassPrefix) {
            $collectorClassPrefix = ucwords($collectorClassPrefix);
            $collector = $this->get('App\Service\DataCollectors\\' . $collectorClassPrefix . 'DataCollector');

            if (!$collector instanceof DataCollectorInterface) {
                throw new LogicException('Must be instance of DataCollector');
            }

            $data[strtolower($collectorClassPrefix)] = $collector->collect($ship);
        }

        return $data;
    }

    public function response(Ship $ship, array $dataCollectors): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $this->information($dataCollectors, $ship)
        ],
            200,
            [],
            ['groups' => ['basic', 'self']]
        );
    }

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            SectorDataCollector::class,
            PlayerDataCollector::class,
            SystemDataCollector::class
        ]);
    }

    protected function getActiveShip(): Ship
    {
        /** @var User $user */
        $user = $this->getUser();

        $character = $user->getCharacters()->first();

        if (!$character) {
            throw new LogicException('User has no character');
        }

        $ship = $character->getShips()->first();

        if (!$ship) {
            throw new LogicException('Character has no ship');

        }
        return $ship;
    }
}
