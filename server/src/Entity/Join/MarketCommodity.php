<?php

namespace App\Entity\Join;

use App\Entity\Commodity;
use App\Entity\Component\Market;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Join\MarketCommodityRepository")
 */
class MarketCommodity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Component\Market", inversedBy="marketCommodities")
     * @ORM\JoinColumn(nullable=false)
     */
    private Market $market;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commodity", inversedBy="marketCommodities")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"basic"})
     */
    private Commodity $commodity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"basic"})
     */
    private ?int $sell;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"basic"})
     */
    private ?int $buy;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMarket(): Market
    {
        return $this->market;
    }

    public function setMarket(Market $market): self
    {
        $this->market = $market;

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

    public function getSell(): ?int
    {
        return $this->sell;
    }

    public function setSell(?int $sell): self
    {
        $this->sell = $sell;

        return $this;
    }

    public function getBuy(): ?int
    {
        return $this->buy;
    }

    public function setBuy(?int $buy): self
    {
        $this->buy = $buy;

        return $this;
    }
}
