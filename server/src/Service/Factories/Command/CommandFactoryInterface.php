<?php

namespace App\Service\Factories\Command;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\Ship;
use App\Entity\User;
use App\Exception\CommandValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface CommandFactoryInterface
{
    public function createCommand(Request $request, Ship $ship): CommandInterface;
}
