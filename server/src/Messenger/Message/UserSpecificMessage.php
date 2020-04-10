<?php

namespace App\Messenger\Message;

use App\Entity\User;

class UserSpecificMessage
{
    protected User $user;
    protected $message;

    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
