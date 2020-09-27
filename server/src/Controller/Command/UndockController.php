<?php


namespace App\Controller\Command;


use App\Command\UndockCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\UndockCommandExecutor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UndockController extends AbstractGameController
{
    protected UndockCommandExecutor $commandExecutor;

    public function __construct(UndockCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/undock", methods={"POST"}, defaults={"_schema": ""})
     * @param UndockCommand $command
     * @return Response
     * @throws UserActionException
     */
    public function index(UndockCommand $command): Response
    {
        // Execute the command
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
