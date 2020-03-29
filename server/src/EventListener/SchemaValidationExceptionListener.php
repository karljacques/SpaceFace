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

        $errors = collect($exception->getErrors())->map(function ($error) {
            $error = ['type' => 'validation'] + $error;

            return $error;
        });

        $event->setResponse(new JsonResponse([
            'success' => false,
            'errors' => $errors
        ], 400));
    }
}
