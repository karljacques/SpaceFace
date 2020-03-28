<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\Ship;
use Symfony\Component\HttpFoundation\Request;

class MovementCommandFactory extends AbstractCommandFactory
{
    function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $command = new MovementCommand($ship, $request->request->get('direction'));

        return $command;
    }
}
