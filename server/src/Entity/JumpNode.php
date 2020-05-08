<?php

namespace App\Entity;

use App\Entity\Traits\LocationTrait;
use App\Util\Location;
use App\Util\Vector2;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JumpNodeRepository")
 */
class JumpNode implements Locatable
{
    use LocationTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"basic"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\System")
     * @ORM\JoinColumn(nullable=false)
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

    public function setExitLocation(Location $location): void
    {
        $this->exitSystem = $location->getSystem();
        $this->exitX = $location->getVector()->getX();
        $this->exitY = $location->getVector()->getY();
    }

    /**
     * @Groups({"basic"})
     * @return Location
     */
    public function getExitLocation(): Location
    {
        return new Location($this->exitSystem, new Vector2($this->exitX, $this->exitY));
    }
}
