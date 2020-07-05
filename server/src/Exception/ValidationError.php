<?php


namespace App\Exception;


class ValidationError
{
    private string $message;
    private string $pointer;

    public function __construct(string $message, string $pointer)
    {
        $this->message = $message;
        $this->pointer = $pointer;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getPointer(): string
    {
        return $this->pointer;
    }


}
