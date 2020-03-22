<?php


namespace App\Controller;


use App\Command\MovementCommand;
use App\Exception\UserActionException;
use App\Service\Executors\MovementCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

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
     * @throws UserActionException
     */
    public function index(MovementCommand $move)
    {
        // Execute the command
        $this->commandExecutor->execute($move);

        // Load the current sector data

        $this->entityManager->flush();

        return $this->json([
            "success" => true,
            "data" => [
                "ship" => $move->getShip()
            ]
        ], 200, [], ['groups' => ['basic', 'self']]);
    }
}
