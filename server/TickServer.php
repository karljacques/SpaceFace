<?php

use App\Kernel;
use App\Service\Infrastructure\TickManager;

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$kernel->boot();

Swoole\Timer::tick(100, function (int $timerId, array $params) {
    /** @var Kernel $kernel */
    $kernel = $params[0];


    $tickManager = $kernel->getContainer()->get(TickManager::class);

    $tickManager->tick();
}, [$kernel]);
