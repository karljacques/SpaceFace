<?php


namespace App\Controller\Command;


use App\Command\JumpCommand;
use App\Controller\AbstractCommandController;
use App\Entity\JumpNode;
use App\Exception\UserActionException;
use App\Repository\JumpNodeRepository;
use App\Service\Executors\JumpCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index()
    {
        /** @var JumpCommand $command */
        $command = $this->createCommand(JumpCommand::class);

        // Execute the command
        $this->commandExecutor->execute($command);

        // Load the current sector data
        /** @var JumpNodeRepository $jumpNodeRepository */
        $jumpNodeRepository = $this->entityManager->getRepository(JumpNode::class);
        $entryNodes = $jumpNodeRepository->findEntryNodeByLocation($command->getShip()->getLocation());


        $this->entityManager->flush();

        return $this->json([
            "success" => true,
            "data" => [
                "ship" => $command->getShip(),
                'sector' => [
                    'entryNodes' => $entryNodes
                ]
            ]
        ], 200, [], ['groups' => ['basic', 'self']]);
    }
}
