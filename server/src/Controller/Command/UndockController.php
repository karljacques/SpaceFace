<?php


namespace App\Controller\Command;


use App\Command\UndockCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Service\Executors\UndockCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class UndockController extends AbstractCommandController
{
    protected UndockCommandExecutor $commandExecutor;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        UndockCommandExecutor $commandExecutor,
        EntityManagerInterface $entityManager
    )
    {
        $this->commandExecutor = $commandExecutor;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/undock", methods={"POST"}, defaults={"_schema": ""})
     * @throws UserActionException
     */
    public function index()
    {
        /** @var UndockCommand $command */
        $command = $this->createCommand(UndockCommand::class);

        // Execute the command
        $this->commandExecutor->execute($command);
        $this->entityManager->flush();

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
