<?php


namespace App\Controller;


use App\Command\MovementCommand;
use App\Entity\JumpNode;
use App\Exception\UserActionException;
use App\Messenger\Message\UserSpecificMessage;
use App\Repository\JumpNodeRepository;
use App\Service\Executors\MovementCommandExecutor;
use App\Service\MessageSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

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

        // Load the current sector data
        /** @var JumpNodeRepository $jumpNodeRepository */
        $jumpNodeRepository = $this->entityManager->getRepository(JumpNode::class);
        $entryNodes = $jumpNodeRepository->findEntryNodeByLocation($move->getShip()->getLocation());

        $this->entityManager->flush();

        $bus->dispatch(new UserSpecificMessage($move->getShip()->getUser(), ['action' => 'move_success']));

        return $this->json([
            "success" => true,
            "data" => [
                "ship" => $move->getShip(),
                'sector' => [
                    'entryNodes' => $entryNodes
                ]
            ]
        ], 200, [], ['groups' => ['basic', 'self']]);
    }
}
