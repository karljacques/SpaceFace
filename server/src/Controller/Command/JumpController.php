<?php


namespace App\Controller\Command;


use App\Command\JumpCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\JumpCommandExecutor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JumpController extends AbstractGameController
{
    protected JumpCommandExecutor $commandExecutor;

    public function __construct(JumpCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/jump", methods={"POST"})
     * @param JumpCommand $command
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(JumpCommand $command): Response
    {
        // Execute the command
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
