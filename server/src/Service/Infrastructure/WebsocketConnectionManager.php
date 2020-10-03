<?php


namespace App\Service\Infrastructure;


use App\Entity\User;
use App\Repository\Authentication\SocketTicketRepository;
use Swoole\Http\Request;

class WebsocketConnectionManager
{
    protected SocketTicketRepository $socketTicketRepository;
    /** @var array<array<int>> */
    protected array $userToConnectionMap = [];

    public function __construct(SocketTicketRepository $socketTicketRepository)
    {
        $this->socketTicketRepository = $socketTicketRepository;
    }

    public function getUserFromTicketToken(Request $request): ?User
    {
        $token = $this->getTokenFromRequest($request);

        if (null === $token) {
            // Likely comes from server - work out how to handle another time
            return null;
        }

        $ticket = $this->socketTicketRepository->findOneByToken($token);

        if (null === $ticket) {
            return null;
        }

        return $ticket->getUser();
    }

    private function getTokenFromRequest(Request $request): ?string
    {
        $token = ltrim($request->server['request_uri'], '/');

        if ($token === "")
            return null;

        return $token;
    }
}
