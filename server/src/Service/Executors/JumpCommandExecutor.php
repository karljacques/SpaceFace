<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Command\Validator\JumpCommandValidator;

class JumpCommandExecutor extends AbstractCommandExecutor
{
    public function __construct(JumpCommandValidator $validator)
    {
        $this->setValidator($validator);
    }

    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $command->getShip()->setLocation($command->getNode()->getExitLocation());
    }
}
