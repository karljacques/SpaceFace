<?php

namespace App\EventSubscriber;

use App\Exception\SchemaValidationException;
use App\Exception\ValidationError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestTransformSubscriber implements EventSubscriberInterface
{
    /**
     * @param ControllerEvent $event
     * @return void
     * @throws SchemaValidationException
     */
    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $body = $request->getContent();

        if ($body === '' || !is_string($body)) {
            return;
        }

        $data = json_decode($body, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->throwJsonExceptionError(json_last_error_msg(), 'request_body');
        }

        if (null === $data) {
            return;
        }

        foreach ($data as $key => $value) {
            $request->request->set($key, $value);
        }
    }

    /**
     * @param string $message
     * @param string $pointer
     * @return array
     * @throws SchemaValidationException
     */
    private function throwJsonExceptionError(string $message, string $pointer): array
    {
        throw new SchemaValidationException([new ValidationError($message, $pointer)]);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}
