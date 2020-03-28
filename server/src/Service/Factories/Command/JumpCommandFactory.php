<?php


namespace App\Service\Factories\Command;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Entity\Ship;
use App\Exception\CommandValidationException;
use App\Exception\InvalidLocationException;
use App\Exception\UserActionException;
use App\Service\Factories\LocationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class JumpCommandFactory extends AbstractCommandFactory
{
    protected $locationFactory;

    public function __construct(
        RequestStack $requestStack,
        ValidatorInterface $validator,
        Security $security,
        LocationFactory $locationFactory
    )
    {
        parent::__construct($requestStack, $validator, $security);

        $this->locationFactory = $locationFactory;
    }

    /**
     * @param Request $request
     * @param Ship $ship
     * @return CommandInterface
     * @throws CommandValidationException
     * @throws UserActionException
     */
    function createCommand(Request $request, Ship $ship): CommandInterface
    {
        $target = $request->get('target');

        $constraint = new Assert\Collection([
            'system' => new Assert\Type(['type' => 'integer']),
            'x' => new Assert\Type(['type' => 'integer']),
            'y' => new Assert\Type(['type' => 'integer'])
        ]);

        $violations = $this->validator->validate($target, $constraint);
        if ($violations->count() > 0) {
            throw new CommandValidationException($violations);
        }

        try {
            $location = $this->locationFactory->createLocation($target['system'], $target['x'], $target['y']);
        } catch (InvalidLocationException $e) {
            throw new UserActionException($e->getMessage(), $target);
        }

        return new JumpCommand($ship, $location);
    }
}
