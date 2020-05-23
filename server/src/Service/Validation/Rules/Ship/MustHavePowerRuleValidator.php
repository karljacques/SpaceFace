<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHavePowerRuleValidator implements RuleValidatorInterface
{
    private CacheItemPoolInterface $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHavePowerRule) {
            throw new UnexpectedTypeException($rule, MustHavePowerRule::class);
        }

        $shipKey = sprintf("ship_%s_power", $rule->getShip()->getId());
        $powerItem = $this->cache->getItem($shipKey);

        $power = $powerItem->isHit() ? $powerItem->get() : $rule->getShip()->getMaxPower();


        return $rule->getRequiredPower() <= $power;
    }
}
