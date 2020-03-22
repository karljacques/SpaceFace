<?php

namespace App\Entity;

use App\Util\BoundingBox;
use App\Util\Vector2;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SystemRepository")
 * @ORM\Table(name="solarSystem")
 */
class System
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"basic"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ship", mappedBy="system")
     */
    private $ships;

    public function __construct()
    {
        $this->ships = new ArrayCollection();
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
            $ship->setSystem($this);
        }

        return $this;
    }

    public function removeShip(Ship $ship): self
    {
        if ($this->ships->contains($ship)) {
            $this->ships->removeElement($ship);
            // set the owning side to null (unless already changed)
            if ($ship->getSystem() === $this) {
                $ship->setSystem(null);
            }
        }

        return $this;
    }

    public function getBoundingBox(): BoundingBox
    {
        return new BoundingBox(new Vector2(1, 1), new Vector2(10, 10));
    }
}
