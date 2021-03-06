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
    use TypedPropertySleepTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"basic"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=4)
     * @Groups({"basic"})
     */
    private string $designation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ship", mappedBy="system")
     */
    private Collection $ships;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sizeX;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sizeY;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JumpNode", mappedBy="entrySystem")
     */
    private Collection $jumpNodes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sector", mappedBy="starSystem", orphanRemoval=true)
     */
    private Collection $sectors;

    public function __construct()
    {
        $this->ships = new ArrayCollection();
        $this->jumpNodes = new ArrayCollection();
        $this->sectors = new ArrayCollection();
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
     * @return Collection<int, Ship>
     */
    public function getShips(): Collection
    {
        return $this->ships;
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
     * @return Collection<int, JumpNode>
     */
    public function getJumpNodes(): Collection
    {
        return $this->jumpNodes;
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

    /**
     * @return Collection<int, Sector>
     */
    public function getSectors(): Collection
    {
        return $this->sectors;
    }
}
