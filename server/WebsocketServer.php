<?php

use App\Kernel;
use App\Repository\Authentication\SocketTicketRepository;

$websocket = new \Swoole\WebSocket\Server("0.0.0.0", 9502);

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$kernel->boot();

$websocket->on("start", function (Swoole\WebSocket\Server $server) {
    echo "Swoole WebSocket Server is started at http://127.0.0.1:9502\n";
});

$connectionToUserMap = [];
global $userToConnectionMap;

$websocket->on('open', function (Swoole\WebSocket\Server $websocket, Swoole\Http\Request $request) use ($kernel) {
    global $userToConnectionMap;
    echo "connection open: {$request->fd}\n";
    $token = ltrim($request->server['request_uri'], '/');

    if ($token === '') {
        return;
    }

    /** @var SocketTicketRepository $tokenRepository */
    $tokenRepository = $kernel->getContainer()->get(SocketTicketRepository::class);
    $ticket          = $tokenRepository->findOneByToken($token);

    $userToConnectionMap[$ticket->getUser()->getId()][] = $request->fd;
    var_dump('UserID:' . $ticket->getUser()->getId());
    var_dump($userToConnectionMap);
});

$websocket->on('message', function (Swoole\WebSocket\Server $websocket, Swoole\WebSocket\Frame $frame) {
    global $userToConnectionMap;
    // When we receive a message, identify the user that it's for, and send it on.
    $data   = json_decode($frame->data);
    $userId = $data->user_id;
    $data   = json_encode($data->data);

    var_dump('UserID:' . $userId);
    if (!isset($userToConnectionMap[$userId])) {
        var_dump($userToConnectionMap);
        echo 'No connections for user ' . $userId;
        return;
    }

    $connections = $userToConnectionMap[$userId];

    foreach ($connections as $connection) {
        $websocket->send($connection, $data);
    }

});

$websocket->on('close', function (Swoole\WebSocket\Server $server, int $fd) {
    echo "connection close: {$fd}\n";
});


$websocket->start();
