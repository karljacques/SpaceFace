<?php

namespace App\Service\Factories\Command;

use App\Command\CommandInterface;
use App\Entity\Ship;
use Symfony\Component\HttpFoundation\Request;

interface CommandFactoryInterface
{
    public function createCommand(Request $request, Ship $ship): CommandInterface;

    public function getSchema(): string;
}
