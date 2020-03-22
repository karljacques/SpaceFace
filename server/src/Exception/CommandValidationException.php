<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class CommandValidationException extends Exception
{
    private $violationList;

    /**
     * CommandValidationException constructor.
     * @param ConstraintViolationListInterface $validationErrors
     */
    public function __construct(ConstraintViolationListInterface $validationErrors)
    {
        $this->violationList = $validationErrors;

        parent::__construct('Validation Exception', 400, null);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
