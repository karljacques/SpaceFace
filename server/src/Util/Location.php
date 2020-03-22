<?php


namespace App\Util;


use App\Entity\System;

class Location
{
    private $system;
    private $vector;

    public function __construct(System $system, Vector2 $vector)
    {
        $this->system = $system;
        $this->vector = $vector;
    }

    /**
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @return Vector2
     */
    public function getVector(): Vector2
    {
        return $this->vector;
    }
}
