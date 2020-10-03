<?php


namespace App\Service\Validation\Rules\Ship;


use App\Repository\Realtime\ShipRealtimeStatusRepositoryInterface;
use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustHavePowerRuleValidator implements RuleValidatorInterface
{
    private ShipRealtimeStatusRepositoryInterface $shipRealtimeStatusRepository;

    public function __construct(ShipRealtimeStatusRepositoryInterface $cache)
    {
        $this->shipRealtimeStatusRepository = $cache;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustHavePowerRule) {
            throw new UnexpectedTypeException($rule, MustHavePowerRule::class);
        }

        $status = $this->shipRealtimeStatusRepository->findOneByShip($rule->getShip());

        $power = $status->getPower();

        return $rule->getRequiredPower() <= $power;
    }
}
