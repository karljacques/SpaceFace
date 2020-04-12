<?php

namespace App\Entity;

use App\Entity\Traits\LocationTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectorRepository")
 */
class Sector
{
    use LocationTrait;

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
}
