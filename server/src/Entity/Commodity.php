<?php

namespace App\Entity;

use App\Entity\Join\MarketCommodity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommodityRepository")
 */
class Commodity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Join\MarketCommodity", mappedBy="commodity")
     */
    private $marketCommodities;

    public function __construct()
    {
        $this->marketCommodities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection|MarketCommodity[]
     */
    public function getMarketCommodities(): Collection
    {
        return $this->marketCommodities;
    }

    public function addMarketCommodity(MarketCommodity $marketCommodity): self
    {
        if (!$this->marketCommodities->contains($marketCommodity)) {
            $this->marketCommodities[] = $marketCommodity;
            $marketCommodity->setCommodity($this);
        }

        return $this;
    }

    public function removeMarketCommodity(MarketCommodity $marketCommodity): self
    {
        if ($this->marketCommodities->contains($marketCommodity)) {
            $this->marketCommodities->removeElement($marketCommodity);
            // set the owning side to null (unless already changed)
            if ($marketCommodity->getCommodity() === $this) {
                $marketCommodity->setCommodity(null);
            }
        }

        return $this;
    }
}
