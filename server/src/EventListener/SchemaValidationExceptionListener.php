<?php


namespace App\EventListener;


use App\Exception\SchemaValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class SchemaValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof SchemaValidationException) {
            return;
        }
        
        $event->setResponse(new JsonResponse(['errors' => $exception->getErrors()]));
    }
}
