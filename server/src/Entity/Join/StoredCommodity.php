<?php

namespace App\Entity\Join;

use App\Entity\Commodity;
use App\Entity\Component\Storage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Component\Storage", inversedBy="storedCommodities")
     * @ORM\JoinColumn(nullable=false)
     */
    private Storage $storage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commodity")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"basic"})
     */
    private Commodity $commodity;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $quantity;

    public function getId(): ?int
    {
        return $this->id;
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
