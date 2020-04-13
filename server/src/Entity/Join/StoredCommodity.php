<?php

namespace App\Entity\Join;

use App\Entity\Commodity;
use App\Entity\Component\Storage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Join\StoredCommodityRepository")
 */
class StoredCommodity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Component\Storage", inversedBy="storedCommodities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $storageComponent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commodity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commodity;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommodity(): Commodity
    {
        return $this->commodity;
    }

    public function setCommodity(Commodity $commodity): self
    {
        $this->commodity = $commodity;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
