<?php


namespace App\Controller;


use App\Repository\JumpNodeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StatusController extends AbstractGameController
{
    protected Security $security;
    protected JumpNodeRepository $jumpNodeRepository;

    public function __construct(Security $security, JumpNodeRepository $jumpNodeRepository)
    {
        $this->security = $security;
        $this->jumpNodeRepository = $jumpNodeRepository;
    }

    /**
     * @Route("/status", methods={"GET"})
     * @return JsonResponse
     */
    public function index()
    {
       $ship = $this->getActiveShip();

        return $this->response($ship, ['sector', 'player', 'system']);
    }
}
