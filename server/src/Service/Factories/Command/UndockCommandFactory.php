<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\UndockCommand;
use App\Entity\Ship;
use Symfony\Component\HttpFoundation\Request;

class UndockCommandFactory implements CommandFactoryInterface
{

    public function createCommand(Request $request, Ship $ship): CommandInterface
    {
        return new UndockCommand($ship);
    }

    public function getSchema(): string
    {
        return '';
    }
}
