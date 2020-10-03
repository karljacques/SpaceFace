<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Entity\Ship;
use App\Entity\ShipRealtimeStatus;
use App\Exception\UserActionException;
use App\Service\ShipRealtimeStatusService;
use App\Service\Validation\RuleValidatorLocator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

abstract class AbstractCommandExecutor implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    abstract protected function executeCommand(CommandInterface $command): void;

    /**
     * @param CommandInterface $command
     *
     * @return void
     * @throws UserActionException
     */
    public function execute(CommandInterface $command): void
    {
        $rules = $command->getValidationRules();
        $violations = [];

        foreach ($rules as $rule) {
            $validator = $this->ruleValidatorLocator()->getRuleValidator($rule);

            if (!$validator->validate($rule)) {
                $violations[] = new UserActionViolation($rule->getViolationMessage(), []);
            }

        }

        if (count($violations) > 0) {
            throw new UserActionException($violations);
        }

        $this->executeCommand($command);
        $this->entityManager()->flush();
    }

    public function ruleValidatorLocator(): RuleValidatorLocator
    {
        return $this->container->get(__METHOD__);
    }

    protected function shipRealtimeStatusService(): ShipRealtimeStatusService
    {
        return $this->container->get(__METHOD__);
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->container->get(__METHOD__);
    }

    protected function getRealtimeStatus(Ship $ship): ShipRealtimeStatus
    {
        return $this->shipRealtimeStatusService()->getShipStatus($ship);
    }

    protected function persistRealtimeStatus(ShipRealtimeStatus $status): void
    {
        $this->shipRealtimeStatusService()->persist($status);
    }
}
