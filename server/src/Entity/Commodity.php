<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommodityRepository")
 */
class Commodity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"basic"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"basic"})
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $size;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Join\MarketCommodity", mappedBy="commodity")
     */
    private Collection $marketCommodities;

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
}
