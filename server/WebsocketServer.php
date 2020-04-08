<?php

use App\Kernel;
use App\Service\Infrastructure\WebsocketConnectionManager;
use Swoole\Table;
use Swoole\WebSocket\Server;

$connectionTable = new Table(1024);
$connectionTable->column('userId', Table::TYPE_INT);
$connectionTable->column('connectionId', Table::TYPE_INT);
$connectionTable->create();

$websocket = new Server("0.0.0.0", 9502);

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$kernel->boot();

$websocket->on("start", function (Swoole\WebSocket\Server $server) {
    echo "Swoole WebSocket Server is started at http://127.0.0.1:9502\n";
});

$websocket->on('connect', function () {
    echo "onConnect\n";
});


$websocket->on('open', function (Swoole\WebSocket\Server $websocket, Swoole\Http\Request $request) use (&$kernel, $connectionTable) {

    echo "connection open: {$request->fd}\n";

    /** @var WebsocketConnectionManager $connectionManager */
    $connectionManager = $kernel->getContainer()->get(WebsocketConnectionManager::class);
    $userId            = $connectionManager->onConnectionOpen($request);

    if ($userId === 0) {
        return;
    }
    $connectionTable->set($userId, [
        'userId'       => $userId,
        'connectionId' => $request->fd
    ]);
});

$websocket->on('message', function (Swoole\WebSocket\Server $websocket, Swoole\WebSocket\Frame $frame) use (&$kernel, $connectionTable) {

    // When we receive a message, identify the user that it's for, and send it on.
    $data   = json_decode($frame->data);
    $userId = $data->user_id;
    $data   = json_encode($data->data);

    $connection = $connectionTable->get($userId);

    if ($connection === false) {
        echo "No connection for user $userId\n";
    }

    $connectionId = $connection['connectionId'];
    $websocket->push($connectionId, $data);
});

$websocket->on('close', function (Swoole\WebSocket\Server $server, int $fd) {
    echo "connection close: {$fd}\n";
});


$websocket->start();
