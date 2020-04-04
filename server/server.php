#!/usr/bin/env php
<?php

declare(strict_types=1);

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

use App\Kernel;

require_once('vendor/autoload.php');
require_once './config/bootstrap.php';

use Indragunawan\SwooleHttpMessageBridge\Symfony\Request as RequestFactory;
use Indragunawan\SwooleHttpMessageBridge\Symfony\Response as ResponseWriter;

$http = new Server("0.0.0.0", 9501);

$http->on(
    "start",
    function (Server $http) {
        echo "Swoole HTTP server is started.\n";
    }
);
$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);

$http->on(
    "request",
    function (Request $request, Response $response) use ($kernel) {

        $sfRequest = RequestFactory::createFromSwooleRequest($request);

        try {
            $sfResponse = $kernel->handle($sfRequest);
            $kernel->terminate($sfRequest, $sfResponse);

            ResponseWriter::writeSwooleResponse($response, $sfResponse);
        } catch (Exception $e) {
            $response->end($e->getMessage());
        }
    }
);

$http->start();
