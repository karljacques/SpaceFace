<?php


namespace App\Security;


use App\Entity\Authentication\SocketTicket;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class SocketTicketFactory
{
    protected $security;
    protected $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security      = $security;
        $this->entityManager = $entityManager;
    }

    public function createSocketTicket(): SocketTicket
    {
        $socketTicket = new SocketTicket();

        /** @var User $user */
        $user = $this->security->getUser();

        $socketTicket->setUser($user);

        $token = bin2hex(random_bytes(16));

        $socketTicket->setToken($token);

        $this->entityManager->persist($socketTicket);
        $this->entityManager->flush();

        return $socketTicket;
    }
}
