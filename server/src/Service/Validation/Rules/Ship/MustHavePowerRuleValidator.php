<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\ShipRealtimeStatusService;
use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHavePowerRuleValidator implements RuleValidatorInterface
{
    private ShipRealtimeStatusService $cache;

    public function __construct(ShipRealtimeStatusService $cache)
    {
        $this->cache = $cache;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHavePowerRule) {
            throw new UnexpectedTypeException($rule, MustHavePowerRule::class);
        }

        $status = $this->cache->getShipStatus($rule->getShip());
        $power = $status->getPower();

        /**  */
        return $rule->getRequiredPower() <= $power;
    }
}
