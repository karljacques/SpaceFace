<?php


namespace App\Command;

use App\Entity\Ship;
use App\Util\Location;


class JumpCommand implements CommandInterface
{
    protected $ship;
    protected $target;

    public function __construct(Ship $ship, Location $target)
    {
        $this->ship = $ship;
        $this->target = $target;
    }
}
