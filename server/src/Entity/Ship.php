<?php

namespace App\Entity;


use App\Entity\Component\Storage;
use App\Entity\Traits\LocationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipRepository")
 */
class Ship implements Locatable
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
     * @Groups({"self"})
     */
    private ?Dockable $docked_at = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Component\Storage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"self"})
     * @SerializedName("cargo")
     */
    private Storage $storageComponent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Character", inversedBy="ships")
     */
    private Character $owner;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $maxPower;

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

    /**
     * @Groups({"self"})
     * @return bool
     */
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

    public function setOwner(Character $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getMaxPower(): ?int
    {
        return $this->maxPower;
    }

    public function setMaxPower(int $maxPower): self
    {
        $this->maxPower = $maxPower;

        return $this;
    }
}
