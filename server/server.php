#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once('vendor/autoload.php');
require_once './config/bootstrap.php';

if (getenv('MODE') === 'WEBSOCKET') {
    require_once('./WebsocketServer.php');
} else {
    require_once('./HttpServer.php');
}

