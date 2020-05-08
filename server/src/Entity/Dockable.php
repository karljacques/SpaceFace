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
class Dockable implements Locatable
{
    use LocationTrait;
    use TypedPropertySleepTrait;

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
     * @return Collection<int, Ship>
     */
    public function getShips(): Collection
    {
        return $this->ships;
    }

    /**
     * @return Collection<int, Market>
     */
    public function getMarkets(): Collection
    {
        return $this->markets;
    }
}
