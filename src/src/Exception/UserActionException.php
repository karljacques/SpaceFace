<?php


namespace App\Exception;

class UserActionException extends \Exception
{
    protected $details;

    public function __construct(string $message, array $details)
    {
        parent::__construct($message, 200);

        $this->details = $details;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
