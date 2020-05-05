<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Command\Validator\UndockCommandValidator;

class UndockCommandExecutor extends AbstractCommandExecutor
{
    public function __construct(UndockCommandValidator $validator)
    {
        $this->setValidator($validator);
    }

    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof UndockCommand) {
            throw new UnexpectedCommandException($command, UndockCommand::class);
        }

        $ship = $command->getShip();

        $ship->setDockedAt(null);
    }
}
