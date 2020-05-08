<?php

namespace App\Entity\Component;

use App\Entity\Join\StoredCommodity;
use App\Entity\TypedPropertySleepTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Component\StorageRepository")
 */
class Storage
{
    use TypedPropertySleepTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Join\StoredCommodity", mappedBy="storage")
     */
    private Collection $storedCommodities;

    /**
     * @ORM\Column(type="integer")
     */
    private int $capacity;

    public function __construct()
    {
        $this->storedCommodities = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, StoredCommodity>
     */
    public function getStoredCommodities(): Collection
    {
        return $this->storedCommodities;
    }

    public function addStoredCommodity(StoredCommodity $storedCommodity): self
    {
        if (!$this->storedCommodities->contains($storedCommodity)) {
            $this->storedCommodities[] = $storedCommodity;
            $storedCommodity->setStorage($this);
        }

        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getCapacityUsage(): int
    {
        $storedCommodities = $this->getStoredCommodities();

        $usage = 0;
        foreach ($storedCommodities as $commodity) {
            $usage += $commodity->getQuantity() * $commodity->getCommodity()->getSize();
        }

        return $usage;
    }

    public function getFreeCapacity(): int
    {
        return $this->capacity - $this->getCapacityUsage();
    }

    public function getWeight(): int
    {
        $storedCommodities = $this->getStoredCommodities();

        $weight = 0;

        foreach ($storedCommodities as $commodity) {
            $weight += $commodity->getQuantity() * $commodity->getCommodity()->getWeight();
        }

        return $weight;
    }
}
