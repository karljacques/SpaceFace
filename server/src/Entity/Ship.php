<?php

namespace App\Entity;

use App\Util\Location;
use App\Util\Vector2;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipRepository")
 */
class Ship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System", inversedBy="ships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $system;

    /**
     * @ORM\Column(type="integer")
     */
    private $fuel;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxFuel;

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    /**
     * @return System
     */
    public function getSystem(): System
    {
        return $this->system;
    }

    /**
     * @param System $system
     * @return Ship
     */
    public function setSystem(System $system)
    {
        $this->system = $system;
        return $this;
    }

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
     * @Groups({"self"})
     * @return int
     */
    public function getFuel(): int
    {
        return $this->fuel;
    }

    public function setFuel(int $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @Groups({"self"})
     * @return int
     */
    public function getMaxFuel(): int
    {
        return $this->maxFuel;
    }

    public function setMaxFuel(int $maxFuel): self
    {
        $this->maxFuel = $maxFuel;

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
