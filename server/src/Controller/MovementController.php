<?php


namespace App\Controller;


use App\Command\MovementCommand;
use App\Entity\JumpNode;
use App\Entity\User;
use App\Exception\UserActionException;
use App\Repository\JumpNodeRepository;
use App\Service\Executors\MovementCommandExecutor;
use App\Service\Factories\Command\MovementCommandFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

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
    public function index()
    {
        $move = $this->createCommand(MovementCommand::class);

        // Execute the command
        $this->commandExecutor->execute($move);

        // Load the current sector data
        /** @var JumpNodeRepository $jumpNodeRepository */
        $jumpNodeRepository = $this->entityManager->getRepository(JumpNode::class);
        $entryNodes = $jumpNodeRepository->findEntryNodeByLocation($move->getShip()->getLocation());

        $this->entityManager->flush();


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
