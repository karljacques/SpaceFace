<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Exception\UserActionException;
use App\Service\Validation\Command\Validator\AbstractCommandValidator;

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
     *
     * @return void
     * @throws UserActionException
     *
     */
    public function execute(CommandInterface $command): void
    {
        $this->validator->validate($command);

        $this->executeCommand($command);
    }

}
