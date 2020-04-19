<?php

namespace App\Entity;

use App\Entity\Component\Market;
use App\Entity\Traits\LocationTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DockableRepository")
 */
class Dockable
{
    use LocationTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ship", mappedBy="docked_at")
     */
    private Collection $ships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Component\Market", mappedBy="dockable")
     */
    private Collection $markets;


    public function __construct()
    {
        $this->ships = new ArrayCollection();
        $this->markets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Ship[]
     */
    public function getShips(): Collection
    {
        return $this->ships;
    }

    public function addShip(Ship $ship): self
    {
        if (!$this->ships->contains($ship)) {
            $this->ships[] = $ship;
            $ship->setDockedAt($this);
        }

        return $this;
    }

    public function removeShip(Ship $ship): self
    {
        if ($this->ships->contains($ship)) {
            $this->ships->removeElement($ship);
            // set the owning side to null (unless already changed)
            if ($ship->getDockedAt() === $this) {
                $ship->setDockedAt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Market[]
     */
    public function getMarkets(): Collection
    {
        return $this->markets;
    }

    public function addMarket(Market $market): self
    {
        if (!$this->markets->contains($market)) {
            $this->markets[] = $market;
            $market->setDockable($this);
        }

        return $this;
    }

    public function removeMarket(Market $market): self
    {
        if ($this->markets->contains($market)) {
            $this->markets->removeElement($market);
            // set the owning side to null (unless already changed)
            if ($market->getDockable() === $this) {
                $market->setDockable(null);
            }
        }

        return $this;
    }
}
