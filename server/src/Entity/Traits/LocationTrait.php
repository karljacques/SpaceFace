<?php


namespace App\Entity\Traits;

use App\Entity\System;
use App\Util\HexVector;
use App\Util\Location;
use Symfony\Component\Serializer\Annotation\Groups;

trait LocationTrait
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System")
     * @ORM\JoinColumn(nullable=false)
     */
    private $system;

    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @return HexVector
     */
    public function getVector(): HexVector
    {
        return new HexVector($this->getX(), $this->getY());
    }

    public function setVector(HexVector $position): void
    {
        $this->setX($position->getQ());
        $this->setY($position->getR());
    }

    /**
     * @Groups({"self"})
     * @return Location
     */
    public function getLocation(): Location
    {
        return new Location($this->getSystem(), $this->getVector());
    }

    /**
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @param System $system
     * @return self
     */
    public function setSystem(System $system)
    {
        $this->system = $system;
        return $this;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function setLocation(Location $location): self
    {
        $this->system = $location->getSystem();
        $this->x = $location->getVector()->getQ();
        $this->y = $location->getVector()->getR();

        return $this;
    }

}
