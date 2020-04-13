<?php

namespace App\Entity\Join;

use App\Entity\Commodity;
use App\Entity\Component\Market;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Join\MarketCommodityRepository")
 */
class MarketCommodity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
     */
    private Commodity $commodity;

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
}
