<?php

namespace App\Entity\Component;

use App\Entity\Commodity;
use App\Entity\Join\StoredCommodity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Component\StorageRepository")
 */
class Storage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Join\StoredCommodity", mappedBy="storageComponent")
     */
    private $storedCommodities;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    public function __construct()
    {
        $this->storedCommodities = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|StoredCommodity[]
     */
    public function getStoredCommodities(): Collection
    {
        return $this->storedCommodities;
    }

    public function addStoredCommodity(StoredCommodity $storedCommodity): self
    {
        if (!$this->storedCommodities->contains($storedCommodity)) {
            $this->storedCommodities[] = $storedCommodity;
            $storedCommodity->setStorageComponent($this);
        }

        return $this;
    }

    public function removeStoredCommodity(StoredCommodity $storedCommodity): self
    {
        if ($this->storedCommodities->contains($storedCommodity)) {
            $this->storedCommodities->removeElement($storedCommodity);
            // set the owning side to null (unless already changed)
            if ($storedCommodity->getStorageComponent() === $this) {
                $storedCommodity->setStorageComponent(null);
            }
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