<?php


namespace App\Service;


use App\Entity\User;
use Swoole\Coroutine\Http\Client;

class MessageSender
{
    public function send(User $user, $data): void
    {
        $message = json_encode(
            [
                'user_id' => $user->getId(),
                'data'    => $data
            ]);

        go(
            function () use ($message) {
                $cli = new Client("php-swoole-websocket", 9502);
                $cli->upgrade('/');
                $cli->push((string)$message);
                $cli->close();
            }
        );
    }
}
