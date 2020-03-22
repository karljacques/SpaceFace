<?php

namespace App\EventListener;

use App\Exception\CommandValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolation;

class CommandValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof CommandValidationException) {
            return;
        }

        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($exception->getViolationList() as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        $event->setResponse(new JsonResponse(['success' => false, 'errors' => $errors]));
        $event->getResponse()->setStatusCode($exception->getCode());

    }
}
