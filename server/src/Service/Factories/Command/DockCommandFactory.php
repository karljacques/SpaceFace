<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\DockCommand;
use App\Entity\Ship;
use App\Repository\DockableRepository;
use Symfony\Component\HttpFoundation\Request;

class DockCommandFactory implements CommandFactoryInterface
{
    protected DockableRepository $dockableRepository;

    public function __construct(DockableRepository $dockableRepository)
    {
        $this->dockableRepository = $dockableRepository;
    }

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $dockable = $this->dockableRepository->find($request->get('dockable'));

        return new DockCommand($ship, $dockable);
    }

    public function getSchema(): string
    {
        return 'dock.json';
    }
}
