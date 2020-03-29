<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\Ship;
use App\Util\Vector2;
use LogicException;
use Symfony\Component\HttpFoundation\Request;

class MovementCommandFactory implements CommandFactoryInterface
{
    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $direction = $request->get('direction');
        $translation = $this->convertDirectionToTranslation($direction);

        return new MovementCommand($ship, $translation, 5);
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

    public function getSchema(): string
    {
        return 'move.json';
    }
}
