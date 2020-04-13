<?php

namespace App\Entity;


use App\Entity\Component\Storage;
use App\Entity\Traits\LocationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private int $id;


    /**
     * @ORM\Column(type="integer")
     */
    private int $fuel;

    /**
     * @ORM\Column(type="integer")
     */
    private int $maxFuel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dockable", inversedBy="ships")
     */
    private ?Dockable $docked_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Component\Storage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Storage $storageComponent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Character", inversedBy="ships")
     */
    private Character $owner;

    /**
     * @Groups({"basic"})
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

    public function getStorageComponent(): ?Storage
    {
        return $this->storageComponent;
    }

    public function setStorageComponent(Storage $storageComponent): self
    {
        $this->storageComponent = $storageComponent;

        return $this;
    }

    public function getOwner(): ?Character
    {
        return $this->owner;
    }

    public function setOwner(?Character $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
