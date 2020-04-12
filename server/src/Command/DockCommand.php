<?php


namespace App\Command;


use App\Entity\Dockable;
use App\Entity\Ship;
use App\Service\Factories\Command\DockCommandFactory;

class DockCommand extends AbstractShipCommand
{
    protected Dockable $dockable;

    public function __construct(Ship $ship, Dockable $dockable)
    {
        $this->dockable = $dockable;

        parent::__construct($ship);
    }

    public static function getFactoryName(): string
    {
        return DockCommandFactory::class;
    }

    /**
     * @return Dockable
     */
    public function getDockable(): Dockable
    {
        return $this->dockable;
    }
}
