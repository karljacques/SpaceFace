<?php


namespace App\EventListener;


use App\Exception\ValidationError;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationExceptionListener
{
    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ValidationException) {
            return;
        }

        $errors = collect($exception->getErrors())->map(fn(ValidationError $error) => [
            'type' => 'validation',
            'property' => $error->getPointer(),
            'message' => $error->getMessage()
        ]);

        $event->setResponse(new JsonResponse([
            'success' => false,
            'errors' => $errors
        ], 400));
    }
}
