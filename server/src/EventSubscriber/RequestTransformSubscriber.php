<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestTransformSubscriber implements EventSubscriberInterface
{
    /**
     * @param ControllerEvent $event
     * @return void
     */
    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();

        $body = $request->getContent();
        $data = json_decode($body, true);

        if (null === $data) {
            return;
        }

        foreach ($data as $key => $value) {
            $request->request->set($key, $value);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}
