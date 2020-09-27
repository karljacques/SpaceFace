<?php


namespace App\Controller\Command\Economy\Market;


use App\Command\Economy\Market\SellCommand;
use App\Controller\AbstractGameController;
use App\Exception\UserActionException;
use App\Service\Executors\Economy\Market\SellCommandExecutor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SellController extends AbstractGameController
{
    private SellCommandExecutor $commandExecutor;

    public function __construct(SellCommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * @Route("/economy/market/sell", methods={"POST"}, defaults={"_schema":"economy/market/purchase.json"})
     * @param SellCommand $command
     * @return JsonResponse
     * @throws UserActionException
     */
    public function index(SellCommand $command)
    {
        $this->commandExecutor->execute($command);

        return $this->response($command->getShip(), ['player', 'sector', 'system']);
    }
}
