<?php


namespace App\Controller;


use App\Command\MovementCommand;
use App\Entity\JumpNode;
use App\Exception\UserActionException;
use App\Repository\JumpNodeRepository;
use App\Service\Executors\MovementCommandExecutor;
use App\Service\MessageSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Response
     * @throws UserActionException
     */
    public function index(MessageSender $sender)
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

        $sender->send($move->getShip()->getUser(), 'move_success');

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
