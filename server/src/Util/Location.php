<?php


namespace App\Util;


use App\Entity\System;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Location
{
    private System $system;
    private HexVector $vector;

    public function __construct(System $system, HexVector $vector)
    {
        $this->system = $system;
        $this->vector = $vector;
    }

    /**
     * @Groups({"basic"})
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @Groups({"basic"})
     * @SerializedName("position")
     * @return HexVector
     */
    public function getVector(): HexVector
    {
        return $this->vector;
    }

    public function equals(Location $location): bool
    {
        if ($location->getSystem()->getId() !== $this->getSystem()->getId()) {
            return false;
        }

        return $this->getVector()->equals($location->getVector());
    }
}
