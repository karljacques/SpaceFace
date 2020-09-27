<?php


namespace App\Controller\Command;


use App\Command\MovementCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\MovementCommandExecutor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovementController extends AbstractGameController
{
    protected MovementCommandExecutor $commandExecutor;

    public function __construct(MovementCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/move", methods={"POST"})
     * @param MovementCommand $command
     * @return Response
     * @throws UserActionException
     */
    public function index(MovementCommand $command)
    {
        // Execute the command
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
