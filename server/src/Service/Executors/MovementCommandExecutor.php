<?php

namespace App\Service\Executors;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validator\MovementCommandValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MovementCommandExecutor extends AbstractCommandExecutor
{
    public function __construct(MovementCommandValidator $validator)
    {
        $this->setValidator($validator);
    }

    /**
     * @param CommandInterface $command
     */
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof MovementCommand) {
            throw new UnexpectedCommandException($command, MovementCommand::class);
        }

        $ship = $command->getShip();
        $ship->setVector($command->getProposedPosition());

        $ship->setFuel($ship->getFuel() - $command->getFuelCost());
    }
}
