<?php


namespace App\Controller;


use App\Entity\Ship;
use App\Entity\User;
use App\Repository\JumpNodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StatusController extends AbstractController
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
        /** @var User $user */
        $user = $this->security->getUser();
        /** @var Ship $ship */
        $ship = $user->getShips()->first();

        $entryNodes = $this->jumpNodeRepository->findEntryNodeByLocation($ship->getLocation());

        return $this->json([
            "success" => true,
            "data" => [
                "ship" => $ship,
                'sector' => [
                    'entryNodes' => $entryNodes
                ]
            ]
        ], 200, [], ['groups' => ['basic', 'self']]);
    }
}
