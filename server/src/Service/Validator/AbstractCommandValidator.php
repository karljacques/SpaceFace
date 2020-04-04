<?php

namespace App\Service\Validator;

use App\Command\CommandInterface;
use App\Exception\UserActionException;

abstract class AbstractCommandValidator
{
    private $violations = [];

    abstract protected function runValidation(CommandInterface $command);

    /**
     * @param CommandInterface $command
     * @throws UserActionException
     */
    public function validate(CommandInterface $command)
    {
        $this->runValidation($command);

        if (!$this->isValid()) {
            $violationsToThrow = $this->violations;

            $this->violations = [];

            throw new UserActionException($violationsToThrow);
        }
    }

    protected function addViolation(string $message, array $details = []): void
    {
        $this->violations[] = new UserActionViolation($message, $details);
    }

    private function isValid()
    {
        return count($this->violations) === 0;
    }
}
