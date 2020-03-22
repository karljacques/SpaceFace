<?php


namespace App\EventListener;


use App\Exception\UserActionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class UserActionExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof UserActionException) {
            return;
        }

        $event->setResponse(new JsonResponse(['success' => false, 'errors' => [$exception->getDetails()]]));
        $event->getResponse()->setStatusCode(400);
    }
}
