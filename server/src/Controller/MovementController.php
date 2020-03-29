<?php


namespace App\Controller;


use App\Command\MovementCommand;
use App\Entity\JumpNode;
use App\Exception\UserActionException;
use App\Repository\JumpNodeRepository;
use App\Service\Executors\MovementCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MovementController extends AbstractController
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
     * @param MovementCommand $move
     * @return Response
     */
    public function index(MovementCommand $move)
    {
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
