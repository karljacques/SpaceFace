<?php

namespace App\EventListener;

use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * https://github.com/lexik/LexikJWTAuthenticationBundle/issues/646
 */
class JWTAuthenticationSuccessListener
{
    private int $tokenLifetime;
    private string $cookieName;
    private int $requiresSecure;

    public function __construct(int $tokenLifetime, string $cookieName, bool $requiresSecure)
    {
        $this->tokenLifetime = $tokenLifetime;
        $this->cookieName = $cookieName;
        $this->requiresSecure = $requiresSecure;
    }

    /**
     * Sets JWT as a cookie on successful authentication.
     *
     * @param AuthenticationSuccessEvent $event
     * @throws Exception
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $event->getResponse()->headers->setCookie(
            new Cookie(
                $this->cookieName,
                $event->getData()['token'], // cookie value
                time() + $this->tokenLifetime, // expiration
                ' / ', // path
                null, // domain, null means that Symfony will generate it on its own.
                $this->requiresSecure, // secure
                true, // httpOnly
                false, // raw
                'lax' // same-site parameter, can be 'lax' or 'strict'.
            )
        );
    }
}
