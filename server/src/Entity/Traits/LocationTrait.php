<?php


namespace App\Entity\Traits;

use App\Entity\System;
use App\Util\Location;
use App\Util\Vector2;
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
     * @return Vector2
     */
    public function getVector(): Vector2
    {
        return new Vector2($this->getX(), $this->getY());
    }

    public function setVector(Vector2 $position): void
    {
        $this->setX($position->getX());
        $this->setY($position->getY());
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
        $this->x = $location->getVector()->getX();
        $this->y = $location->getVector()->getY();

        return $this;
    }

}
