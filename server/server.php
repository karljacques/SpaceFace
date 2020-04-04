#!/usr/bin/env php
<?php

declare(strict_types=1);

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;

require_once('vendor/autoload.php');
require_once './config/bootstrap.php';

use Indragunawan\SwooleHttpMessageBridge\Symfony\Request as RequestFactory;
use Indragunawan\SwooleHttpMessageBridge\Symfony\Response as ResponseWriter;


$http = new Server("0.0.0.0", 9501);

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}
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
        $sfRequest = RequestFactory::createFromSwooleRequest($request);

        $sfResponse = $kernel->handle($sfRequest);
        $kernel->terminate($sfRequest, $sfResponse);

        ResponseWriter::writeSwooleResponse($response, $sfResponse);
    }
);

$http->start();
