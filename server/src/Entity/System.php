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
 * @ORM\Table(name="star_system")
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
     * @ORM\Column(type="string", length=4)
     * @Groups({"basic"})
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ship", mappedBy="system")
     */
    private $ships;

    /**
     * @ORM\Column(type="integer")
     */
    private $sizeX;

    /**
     * @ORM\Column(type="integer")
     */
    private $sizeY;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JumpNode", mappedBy="entrySystem")
     */
    private $jumpNodes;

    public function __construct()
    {
        $this->ships = new ArrayCollection();
        $this->jumpNodes = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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
        return new BoundingBox(new Vector2(1, 1), new Vector2($this->getSizeX(), $this->getSizeY()));
    }

    public function getSizeX(): ?int
    {
        return $this->sizeX;
    }

    public function setSizeX(int $sizeX): self
    {
        $this->sizeX = $sizeX;

        return $this;
    }

    public function getSizeY(): ?int
    {
        return $this->sizeY;
    }

    public function setSizeY(int $sizeY): self
    {
        $this->sizeY = $sizeY;

        return $this;
    }

    /**
     * @return Collection|JumpNode[]
     */
    public function getJumpNodes(): Collection
    {
        return $this->jumpNodes;
    }

    public function addJumpNode(JumpNode $jumpNode): self
    {
        if (!$this->jumpNodes->contains($jumpNode)) {
            $this->jumpNodes[] = $jumpNode;
            $jumpNode->setEntrySystem($this);
        }

        return $this;
    }

    public function removeJumpNode(JumpNode $jumpNode): self
    {
        if ($this->jumpNodes->contains($jumpNode)) {
            $this->jumpNodes->removeElement($jumpNode);
            // set the owning side to null (unless already changed)
            if ($jumpNode->getEntrySystem() === $this) {
                $jumpNode->setEntrySystem(null);
            }
        }

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }
}
