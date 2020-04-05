<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Validator\AbstractCommandValidator;

abstract class AbstractCommandExecutor
{
    /** @var AbstractCommandValidator|null */
    private $validator;

    abstract protected function executeCommand(CommandInterface $command): void;

    /**
     * @param AbstractCommandValidator $validator
     * @return AbstractCommandExecutor
     */
    protected function setValidator(AbstractCommandValidator $validator): self
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @param CommandInterface $command
     * @throws UserActionException
     */
    public function execute(CommandInterface $command)
    {
        $this->validator->validate($command);

        $this->executeCommand($command);
    }

}
