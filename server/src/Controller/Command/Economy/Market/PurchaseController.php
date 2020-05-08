<?php


namespace App\Controller\Command\Economy\Market;


use App\Command\Economy\Market\PurchaseCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Service\Executors\Economy\Market\PurchaseCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractCommandController
{
    /**
     * @Route("/economy/market/purchase", methods={"POST"}, defaults={"_schema":"economy/market/purchase.json"})
     * @param PurchaseCommandExecutor $commandExecutor
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(PurchaseCommandExecutor $commandExecutor, EntityManagerInterface $entityManager)
    {
        /** @var PurchaseCommand $command */
        $command = $this->createCommand(PurchaseCommand::class);

        $commandExecutor->execute($command);

        $entityManager->flush();

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
