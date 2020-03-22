<?php

namespace App\Command;

use App\Entity\Ship;
use Symfony\Component\Validator\Constraints as Assert;

class MovementCommand implements CommandInterface
{
    /**
     * @var string
     * @Assert\Choice({"up", "down", "left", "right"}, message="Value must be one of {{ choices }}")
     */
    protected $direction;

    /**
     * @var Ship
     */
    protected $ship;

    public function __construct(Ship $ship, string $direction)
    {
        $this->ship = $ship;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @return Ship
     */
    public function getShip(): Ship
    {
        return $this->ship;
    }


}
