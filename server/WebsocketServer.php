<?php

use App\Kernel;
use App\Service\Infrastructure\WebsocketConnectionManager;
use Swoole\Table;
use Swoole\WebSocket\Frame;
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

$websocket->on('open', function (Swoole\WebSocket\Server $websocket, Swoole\Http\Request $request) use (&$kernel, $connectionTable) {

    /** @var WebsocketConnectionManager $connectionManager */
    $connectionManager = $kernel->getContainer()->get(WebsocketConnectionManager::class);
    $user              = $connectionManager->getUserFromTicketToken($request);

    if (null === $user) {
        return;
    }

    echo sprintf("Swoole websocket server opened a new connection to User '%s' with a connection id of '%s'\n", $user->getId(), $request->fd);

    $connectionTable->set($user->getId(), [
        'userId'       => $user->getId(),
        'connectionId' => $request->fd
    ]);
});

$websocket->on('message', function (Swoole\WebSocket\Server $websocket, Swoole\WebSocket\Frame $frame) use (&$kernel, $connectionTable) {

    list($data, $userId) = extractData($frame);

    $connection = $connectionTable->get($userId);

    if ($connection === false) {
        echo "No connection for user $userId\n";
        return;
    }

    $connectionId = $connection['connectionId'];
    $websocket->push($connectionId, $data);
});

$websocket->on('close', function (Swoole\WebSocket\Server $server, int $fd) use ($connectionTable) {

    foreach ($connectionTable as $index => $row) {
        if ($row['connectionId'] === $fd) {
            echo sprintf("Disconnected from User '%s' on connection '%s'\n", $row['userId'], $fd);
            $connectionTable->del($index);
            break;
        }
    }
});

// When we receive a message, identify the user that it's for, and send it on.
/**
 * @param Frame $frame
 *
 * @return array
 */
function extractData(Swoole\WebSocket\Frame $frame): array
{
    $data   = json_decode($frame->data);
    $userId = $data->user_id;
    $data   = json_encode($data->data);
    return [$data, $userId];
}

$websocket->start();
