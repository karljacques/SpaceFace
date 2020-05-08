<?php

namespace App\Service\Validation\Command;

class UserActionViolation
{
    protected string $message;
    protected array $details;

    public function __construct(string $message, array $details)
    {
        $this->message = $message;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }


}
