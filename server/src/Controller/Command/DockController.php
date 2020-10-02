<?php


namespace App\Controller\Command;


use App\Command\DockCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\DockCommandExecutor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DockController extends AbstractGameController
{
    protected DockCommandExecutor $commandExecutor;

    public function __construct(DockCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/dock", methods={"POST"})
     * @param DockCommand $command
     * @return Response
     * @throws UserActionException
     */
    public function index(DockCommand $command): Response
    {
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
