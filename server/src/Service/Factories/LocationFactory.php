<?php

namespace App\Service\Factories;

use App\Exception\InvalidLocationException;
use App\Repository\SystemRepository;
use App\Util\Location;
use App\Util\Vector2;

class LocationFactory
{
    protected $systemRepository;

    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }

    /**
     * @param int $system_id
     * @param int $x
     * @param int $y
     * @return Location
     * @throws InvalidLocationException
     */
    public function createLocation(int $system_id, int $x, int $y)
    {
        $system = $this->systemRepository->find($system_id);

        if (null === $system) {
            throw new InvalidLocationException('System does not exist');
        }

        $vector = new Vector2($x, $y);

        if (!$system->getBoundingBox()->containsPoint($vector)) {
            throw new InvalidLocationException('Point not within system bounds');
        }

        return new Location($system, $vector);
    }
}
