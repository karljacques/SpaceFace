<?php


namespace App\Service\Infrastructure;


use App\Repository\Authentication\SocketTicketRepository;
use Swoole\Http\Request;

class WebsocketConnectionManager
{
    protected SocketTicketRepository $socketTicketRepository;
    /** @var array<array<int>> */
    protected array $userToConnectionMap = [];

    public function __construct(SocketTicketRepository $socketTicketRepository)
    {
        echo "I've been constructed";
        $this->socketTicketRepository = $socketTicketRepository;
    }

    public function onConnectionOpen(Request $request): int
    {
//        echo sprintf("Identifier: %s \n", spl_object_id($this));
        $token = $this->getTokenFromRequest($request);

        if (null === $token) {
            // Likely comes from server - work out how to handle another time
            return 0;
        }

        $ticket = $this->socketTicketRepository->findOneByToken($token);

        $this->userToConnectionMap[$ticket->getUser()->getId()][] = (int)$request->fd;


        return $ticket->getUser()->getId();
    }

    /**
     * @param int $userId
     *
     * @return array<int>
     */
    public function getConnectionIdForUser(int $userId): ?array
    {
//        echo sprintf("Identifier: %s \n", spl_object_id($this));

        if (!isset($this->userToConnectionMap[$userId])) {
            return null;
        }

        return $this->userToConnectionMap[$userId];
    }

    private function getTokenFromRequest(Request $request): ?string
    {
        $token = ltrim($request->server['request_uri'], '/');

        if ($token === "")
            return null;

        return $token;
    }
}
