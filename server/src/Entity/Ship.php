<?php

namespace App\Entity;


use App\Entity\Traits\LocationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipRepository")
 */
class Ship
{
    use LocationTrait;

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
    private $fuel;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxFuel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dockable", inversedBy="ships")
     */
    private $docked_at;

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getDockedAt(): ?Dockable
    {
        return $this->docked_at;
    }

    public function setDockedAt(?Dockable $docked_at): self
    {
        $this->docked_at = $docked_at;

        return $this;
    }

    public function isDocked(): bool
    {
        return $this->docked_at !== null;
    }
}
