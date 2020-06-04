<?php


namespace App\Controller\Command\Economy\Market;


use App\Command\Economy\Market\PurchaseCommand;
use App\Command\Economy\Market\SellCommand;
use App\Controller\AbstractCommandController;
use App\Exception\UserActionException;
use App\Service\Executors\Economy\Market\SellCommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SellController extends AbstractCommandController
{
    /**
     * @Route("/economy/market/sell", methods={"POST"}, defaults={"_schema":"economy/market/purchase.json"})
     * @param SellCommandExecutor $commandExecutor
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(SellCommandExecutor $commandExecutor, EntityManagerInterface $entityManager)
    {
        /** @var PurchaseCommand $command */
        $command = $this->createCommand(SellCommand::class);

        $commandExecutor->execute($command);

        $entityManager->flush();

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
