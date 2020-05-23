<?php


namespace App\Service\Validation\Rules\Ship;


use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Cache\CacheInterface;

class MustHavePowerRuleValidator implements RuleValidatorInterface
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHavePowerRule) {
            throw new UnexpectedTypeException($rule, MustHavePowerRule::class);
        }

        $shipKey = sprintf("ship_%s_power", $rule->getShip()->getId());
        $power = $this->cache->get($shipKey, function () use ($rule) {
            return $rule->getShip()->getMaxPower();
        });

        return $rule->getRequiredPower() <= $power;
    }
}
