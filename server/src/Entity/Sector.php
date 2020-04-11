<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectorRepository")
 */
class Sector
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System", inversedBy="sectors")
     * @ORM\JoinColumn(nullable=false, name="starSystem")
     */
    private $system;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $y;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSystem(): System
    {
        return $this->system;
    }

    public function setSystem(System $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }
}
