<?php

namespace App\Service\Executors;

use App\Command\MovementCommand;
use App\Exception\UserActionException;
use App\Util\Vector2;
use LogicException;

class MovementCommandExecutor
{
    /**
     * @param MovementCommand $command
     * @throws UserActionException
     */
    public function execute(MovementCommand $command): void
    {
        $ship = $command->getShip();
        $system = $ship->getSystem();

        $direction = $this->convertDirectionToTranslation($command->getDirection());

        $proposedPosition = $ship->getVector()->add($direction);

        if (!$system->getBoundingBox()->containsPoint($proposedPosition)) {
            throw new UserActionException('Proposed movement is out of system bounds',
                [
                'current_position' => $ship->getVector(),
                'delta' => $direction,
                'proposed_position' => $proposedPosition
            ]);
        }

        $ship->setVector($proposedPosition);
    }

    private function convertDirectionToTranslation(string $direction): Vector2
    {
        switch ($direction) {
            case 'up':
                return new Vector2(0, 1);
            case 'down':
                return new Vector2(0, -1);
            case 'left':
                return new Vector2(-1, 0);
            case 'right':
                return new Vector2(1, 0);
        }

        throw new LogicException('Invalid direction');
    }
}
