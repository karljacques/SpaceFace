<?php


namespace App\Exception;


class SchemaValidationException extends ValidationException
{
    public function __construct(array $errors)
    {
        parent::__construct('Schema Validation Exception');
        $this->errors = $errors;
    }
}
