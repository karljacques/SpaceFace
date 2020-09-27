<?php


namespace App\Controller\Command\Economy\Market;


use App\Command\Economy\Market\PurchaseCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\Economy\Market\PurchaseCommandExecutor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractGameController
{
    private PurchaseCommandExecutor $commandExecutor;

    public function __construct(PurchaseCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/economy/market/purchase", methods={"POST"})
     * @param PurchaseCommand $command
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(PurchaseCommand $command)
    {
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
