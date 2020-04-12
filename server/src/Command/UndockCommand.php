<?php


namespace App\Command;


use App\Service\Factories\Command\UndockCommandFactory;

class UndockCommand extends AbstractShipCommand
{
    public static function getFactoryName(): string
    {
        return UndockCommandFactory::class;
    }
}
