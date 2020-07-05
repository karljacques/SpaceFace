<?php


namespace App\Exception;


use Exception;

class ValidationException extends Exception
{
    /** @var ValidationError[] */
    protected array $errors;

    public function __construct(array $errors)
    {
        parent::__construct('Schema Validation Exception');
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
