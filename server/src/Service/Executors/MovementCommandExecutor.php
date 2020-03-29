<?php

namespace App\Service\Executors;

use App\Command\MovementCommand;
use App\Exception\UserActionException;
use App\Service\Validator\MovementCommandValidator;
use App\Util\Vector2;
use LogicException;

class MovementCommandExecutor
{
    protected $validator;

    public function __construct(MovementCommandValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param MovementCommand $command
     * @throws UserActionException
     */
    public function execute(MovementCommand $command): void
    {
        $this->validator->validate($command);

        $ship = $command->getShip();
        $ship->setVector($command->getProposedPosition());
    }
}
