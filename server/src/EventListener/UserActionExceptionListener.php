<?php


namespace App\EventListener;


use App\Exception\UserActionException;
use App\Service\Validator\UserActionViolation;
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

        $errors = collect($exception->getViolations())->map(function(UserActionViolation $violation) {
            return [
                'type' => 'action',
                'message' => $violation->getMessage(),
                'details' => $violation->getDetails()
            ];
        });

        $event->setResponse(new JsonResponse(['success' => false, 'errors' => $errors]));
        $event->getResponse()->setStatusCode(403);
    }
}
