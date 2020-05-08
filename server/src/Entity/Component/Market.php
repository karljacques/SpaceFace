<?php

namespace App\Entity\Component;

use App\Entity\Dockable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Component\MarketRepository")
 */
class Market
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Join\MarketCommodity", mappedBy="market")
     */
    private Collection $marketCommodities;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dockable", inversedBy="market")
     */
    private ?Dockable $dockable = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Component\Storage", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Storage $storage;

    public function __construct()
    {
        $this->marketCommodities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDockable(): ?Dockable
    {
        return $this->dockable;
    }

    public function setDockable(?Dockable $dockable): self
    {
        $this->dockable = $dockable;

        return $this;
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(Storage $storage): self
    {
        $this->storage = $storage;

        return $this;
    }
}
