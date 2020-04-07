<?php


namespace App\Controller\Authentication;


use App\Security\SocketTicketFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocketTicketController extends AbstractController
{
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
