<?php


namespace App\Controller\Command;


use App\Command\JumpCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Service\Executors\JumpCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JumpController extends AbstractCommandController
{
    protected $commandExecutor;
    protected $entityManager;

    public function __construct(
        JumpCommandExecutor $commandExecutor,
        EntityManagerInterface $entityManager
    )
    {
        $this->commandExecutor = $commandExecutor;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/jump", methods={"POST"}, defaults={"_schema": "jump.json"})
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(): Response
    {
        /** @var JumpCommand $command */
        $command = $this->createCommand(JumpCommand::class);

        // Execute the command
        $this->commandExecutor->execute($command);
        $this->entityManager->flush();

        return $this->response($command->getShip(), ['player', 'sector']);
    }
}
