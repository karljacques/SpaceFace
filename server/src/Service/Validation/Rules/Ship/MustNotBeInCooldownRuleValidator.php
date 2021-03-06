<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\ShipRealtimeStatusService;
use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustNotBeInCooldownRuleValidator implements RuleValidatorInterface
{
    private ShipRealtimeStatusService $realtimeStatusService;

    public function __construct(ShipRealtimeStatusService $realtimeStatusService)
    {
        $this->realtimeStatusService = $realtimeStatusService;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustNotBeInCooldownRule) {
            throw new UnexpectedTypeException($rule, MustNotBeInCooldownRule::class);
        }

        $ship = $rule->getShip();

        $status = $this->realtimeStatusService->getShipStatus($ship);

        return $status->getMoveCooldownExpires() === null || $status->getMoveCooldownExpires() < microtime(true);
    }
}
