<?php

namespace App\Entity;

use App\Util\Location;
use App\Util\Vector2;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JumpNodeRepository")
 */
class JumpNode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System", inversedBy="jumpNodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrySystem;

    /**
     * @ORM\Column(type="integer")
     */
    private $entryX;

    /**
     * @ORM\Column(type="integer")
     */
    private $entryY;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"basic"})
     */
    private $exitSystem;

    /**
     * @ORM\Column(type="integer")
     */
    private $exitX;

    /**
     * @ORM\Column(type="integer")
     */
    private $exitY;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrySystem(): ?System
    {
        return $this->entrySystem;
    }

    public function setEntrySystem(?System $entrySystem): self
    {
        $this->entrySystem = $entrySystem;

        return $this;
    }

    public function getEntryX(): ?int
    {
        return $this->entryX;
    }

    public function setEntryX(int $entryX): self
    {
        $this->entryX = $entryX;

        return $this;
    }

    public function getEntryY(): ?int
    {
        return $this->entryY;
    }

    public function setEntryY(int $entryY): self
    {
        $this->entryY = $entryY;

        return $this;
    }

    public function getExitSystem(): ?System
    {
        return $this->exitSystem;
    }

    public function setExitSystem(?System $exitSystem): self
    {
        $this->exitSystem = $exitSystem;

        return $this;
    }

    public function getExitX(): ?int
    {
        return $this->exitX;
    }

    public function setExitX(int $exitX): self
    {
        $this->exitX = $exitX;

        return $this;
    }

    public function getExitY(): ?int
    {
        return $this->exitY;
    }

    public function setExitY(int $exitY): self
    {
        $this->exitY = $exitY;

        return $this;
    }


    /**
     * @return Location
     */
    public function getEntryLocation(): Location
    {
        return new Location($this->entrySystem, new Vector2($this->entryX, $this->entryY));
    }

    public function getExitLocation(): Location
    {
        return new Location($this->exitSystem, new Vector2($this->exitX, $this->exitY));
    }
}
