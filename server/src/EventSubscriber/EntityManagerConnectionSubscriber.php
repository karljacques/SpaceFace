<?php


namespace App\EventSubscriber;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EntityManagerConnectionSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onRequest', 9]
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        $connection = $this->entityManager->getConnection();

        if ($connection->ping()) {
            dump('ping success');
            return;
        }

        $connection->close();
        $connection->connect();

        dump('reconnected');
    }
}
