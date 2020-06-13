<?php

use App\Kernel;
use App\Service\Infrastructure\ResponseWriter;
use Indragunawan\SwooleHttpMessageBridge\Symfony\Request as RequestFactory;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Symfony\Component\ErrorHandler\Debug;

umask(0000);

Debug::enable();

$http   = new Server("0.0.0.0", 9501);
$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);

$http->on(
    "start",
    function (Server $http) {
        echo "Swoole HTTP server is started.\n";
    }
);

$http->on(
    "request",
    function (Request $request, Response $response) use ($kernel) {

        // SqlFormatter will behave differently when it thinks we're in cli, which swoole is
        SqlFormatter::$cli = false;

        $sfRequest = RequestFactory::createFromSwooleRequest($request);

        try {
            $sfResponse = $kernel->handle($sfRequest);
            $kernel->terminate($sfRequest, $sfResponse);

            ResponseWriter::writeSwooleResponse($response, $sfResponse);
        } catch (Exception $e) {
            $response->end((string)$e);
        } finally {
            // Allow normal cli detection to resume
            SqlFormatter::$cli = null;
        }
    }
);

$http->start();
