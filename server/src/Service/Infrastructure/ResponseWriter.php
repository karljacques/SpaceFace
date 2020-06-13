<?php


namespace App\Service\Infrastructure;

use Swoole\Http\Response as SwooleResponse;
use Symfony\Component\HttpFoundation\Response as SfResponse;

class ResponseWriter
{
    /**
     * Writes SwooleResponse with values from SfResponse.
     *
     * @param SwooleResponse $swooleResponse
     * @param SfResponse $sfResponse
     * @param bool $end
     */
    public static function writeSwooleResponse(SwooleResponse $swooleResponse, SfResponse $sfResponse, $end = true)
    {
        // write headers
        self::writeHeaders($swooleResponse, $sfResponse);

        if (true === $end) {
            $swooleResponse->end($sfResponse->getContent());
        } else {
            $swooleResponse->write($sfResponse->getContent());
        }
    }

    /**
     * Writes SwooleResponse headers with values from SfResponse headers.
     * Removed the part about headers sent
     *
     * @param SwooleResponse $swooleResponse
     * @param SfResponse $sfResponse
     */
    protected static function writeHeaders(SwooleResponse $swooleResponse, SfResponse $sfResponse)
    {
        // headers
        foreach ($sfResponse->headers->allPreserveCaseWithoutCookies() as $name => $values) {
            foreach ($values as $value) {
                $swooleResponse->header($name, $value);
            }
        }

        // status
        $swooleResponse->status($sfResponse->getStatusCode());

        // cookies
        foreach ($sfResponse->headers->getCookies() as $cookie) {
            $swooleResponse->cookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        }
    }
}
