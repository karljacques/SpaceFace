<?php


namespace App\Controller\Authentication;


use App\Security\SocketTicketFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SocketTicketController extends AbstractController
{
    /**
     * @Route("/authentication/ticket", methods={"GET"})
     * @param SocketTicketFactory $factory
     * @return JsonResponse
     */
    public function index(SocketTicketFactory $factory)
    {
        return $this->json(
            [
                'success' => true,
                'data'    => [
                    'token' => $factory->createSocketTicket()->getToken()
                ]
            ]);
    }
}
