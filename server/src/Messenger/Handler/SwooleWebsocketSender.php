<?php


namespace App\Messenger\Handler;


use App\Messenger\Message\UserSpecificMessage;
use Swoole\Coroutine\Http\Client;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SwooleWebsocketSender implements MessageHandlerInterface
{

    public function __invoke(UserSpecificMessage $message)
    {
        $data = json_encode(
            [
                'user_id' => $message->getUser()->getId(),
                'data' => $message->getMessage()
            ]);

        go(
            function () use ($data) {
                $cli = new Client("php-swoole-websocket", 9502);
                $cli->upgrade('/');
                $cli->push((string)$data);
                $cli->close();
            }
        );
    }
}
