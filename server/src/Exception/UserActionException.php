<?php


namespace App\Exception;

use App\Service\Validator\UserActionViolation;

class UserActionException extends \Exception
{
    /** @var UserActionViolation[] */
    protected $violations;

    public function __construct(array $violations)
    {
        parent::__construct('User Action Exception', 200);

        $this->violations = $violations;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
