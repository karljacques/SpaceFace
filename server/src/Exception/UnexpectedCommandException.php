<?php


namespace App\Exception;


use LogicException;
use function get_class;
use function gettype;
use function is_object;

class UnexpectedCommandException extends LogicException
{

    /**
     * @param mixed $value
     * @param string $expectedType
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
