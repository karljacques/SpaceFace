<?php

namespace App\Service\Validator;

class UserActionViolation
{
    protected $message;
    protected $details;

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
