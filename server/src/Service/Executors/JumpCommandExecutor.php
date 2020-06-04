<?php


namespace App\Service\Executors;


use App\Command\CommandInterface;
use App\Command\JumpCommand;
use App\Exception\UnexpectedCommandException;
use App\Service\Validation\Rules\Docking\MustNotBeDockedRule;
use App\Service\Validation\Rules\Generic\MustHaveSameLocationRule;
use App\Service\Validation\Rules\Ship\MustHavePowerRule;
use App\Service\Validation\Rules\Ship\MustNotBeInCooldownRule;

class JumpCommandExecutor extends AbstractCommandExecutor
{
    protected function executeCommand(CommandInterface $command): void
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $command->getShip()->setLocation($command->getNode()->getExitLocation());

        $ship = $command->getShip();

        $status = $this->getRealtimeStatus($ship);
        $status->applyCooldown(5)
            ->usePower(500);

        $this->persistRealtimeStatus($status);
    }

    protected function getValidationRules(CommandInterface $command): array
    {
        if (!$command instanceof JumpCommand) {
            throw new UnexpectedCommandException($command, JumpCommand::class);
        }

        $ship = $command->getShip();
        $node = $command->getNode();

        return [
            new MustNotBeDockedRule($ship),
            new MustHaveSameLocationRule($ship, $node),
            new MustNotBeInCooldownRule($ship),
            new MustHavePowerRule($ship, 500)
        ];
    }
}
