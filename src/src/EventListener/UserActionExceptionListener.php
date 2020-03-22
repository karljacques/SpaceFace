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

        $error = [
            'type' => 'action',
            'message' => $exception->getMessage(),
            'details' => $exception->getDetails()
        ];

        $event->setResponse(new JsonResponse(['success' => false, 'error' => $error]));
        $event->getResponse()->setStatusCode(400);
    }
}
