<?php


namespace App\Exception;


use Exception;

class SchemaValidationException extends Exception
{
    protected $errors;

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
