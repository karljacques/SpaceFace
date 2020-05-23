#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once('vendor/autoload.php');
require_once './config/bootstrap.php';

switch (getenv('MODE')) {
    case 'WEBSOCKET':
        require_once('./WebsocketServer.php');
        break;
    case 'HTTP':
        require_once('./HttpServer.php');
        break;
    case 'TICK_SERVER':
        require_once('./TickServer.php');
        break;
}

