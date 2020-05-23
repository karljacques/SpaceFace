<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\ShipStatusCache;
use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHavePowerRuleValidator implements RuleValidatorInterface
{
    private ShipStatusCache $cache;

    public function __construct(ShipStatusCache $cache)
    {
        $this->cache = $cache;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHavePowerRule) {
            throw new UnexpectedTypeException($rule, MustHavePowerRule::class);
        }

        $item = $this->cache->getShipStatus($rule->getShip());
        $power = $item->get()->getPower();

        /**  */
        return $rule->getRequiredPower() <= $power;
    }
}
