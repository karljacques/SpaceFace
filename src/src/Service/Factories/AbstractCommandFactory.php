<?php

namespace App\Service\Factories;

use App\Command\CommandInterface;
use App\Command\MovementCommand;
use App\Entity\Ship;
use App\Entity\User;
use App\Exception\CommandValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractCommandFactory
{
    private $request;
    private $validator;
    private $security;

    public function __construct(
        RequestStack $requestStack,
        ValidatorInterface $validator,
        Security $security
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->validator = $validator;
        $this->security = $security;
    }

    abstract function createCommand(Request $request, Ship $ship): CommandInterface;

    /**
     * @return MovementCommand
     * @throws CommandValidationException
     */
    public function __invoke(): CommandInterface
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $ship = $user->getShips()->first();

        $command = $this->createCommand($this->request, $ship);
        $this->validateCommand($command);

        return $command;
    }

    /**
     * @param CommandInterface $command
     * @return void
     * @throws CommandValidationException
     */
    private function validateCommand(CommandInterface $command): void
    {
        $errors = $this->validator->validate($command);

        if ($errors->count() > 0) {
            throw new CommandValidationException($errors);
        }
    }
}
