<?php


namespace App\Controller\Command;


use App\Command\MovementCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Messenger\Message\UserSpecificMessage;
use App\Service\Executors\MovementCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class MovementController extends AbstractCommandController
{
    protected $commandExecutor;
    protected $entityManager;

    public function __construct(
        MovementCommandExecutor $commandExecutor,
        EntityManagerInterface $entityManager
    )
    {
        $this->commandExecutor = $commandExecutor;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/move", methods={"POST"}, defaults={"_schema"="move.json"})
     * @param MessageBusInterface $bus
     * @return Response
     * @throws UserActionException
     */
    public function index(MessageBusInterface $bus)
    {
        /** @var MovementCommand $move */
        $move = $this->createCommand(MovementCommand::class);

        // Execute the command
        $this->commandExecutor->execute($move);
        $this->entityManager->flush();

        $bus->dispatch(new UserSpecificMessage($move->getShip()->getUser(), ['action' => 'move_success']));

        return $this->response($move->getShip(), ['player', 'sector', 'system']);
    }
}
