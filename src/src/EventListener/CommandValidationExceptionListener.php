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

        $violations = [];
        /** @var ConstraintViolation $violation */
        foreach ($exception->getViolationList() as $violation) {
            $violations[$violation->getPropertyPath()] = $violation->getMessage();
        }

        $error = [
            'type' => 'validation',
            'violations' => $violations
        ];

        $event->setResponse(new JsonResponse(['success' => false, 'error' => $error]));
        $event->getResponse()->setStatusCode($exception->getCode());
    }
}
