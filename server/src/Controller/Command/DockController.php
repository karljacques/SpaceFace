<?php


namespace App\Controller\Command;


use App\Command\DockCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Service\Executors\DockCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DockController extends AbstractCommandController
{
    protected DockCommandExecutor $commandExecutor;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        DockCommandExecutor $commandExecutor,
        EntityManagerInterface $entityManager
    )
    {
        $this->commandExecutor = $commandExecutor;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dock", methods={"POST"}, defaults={"_schema": "dock.json"})
     * @throws UserActionException
     */
    public function index(): Response
    {
        /** @var DockCommand $command */
        $command = $this->createCommand(DockCommand::class);

        $this->commandExecutor->execute($command);
        $this->entityManager->flush();

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
