<?php


namespace App\Service\Validation\Rules\Storage;


use App\Repository\Join\StoredCommodityRepository;
use App\Service\Validation\Rules\RuleInterface;
use App\Service\Validation\Rules\RuleValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class MustContainCommodityInStorageRuleValidator implements RuleValidatorInterface
{
    private StoredCommodityRepository $storedCommodityRepository;

    public function __construct(StoredCommodityRepository $storedCommodityRepository)
    {
        $this->storedCommodityRepository = $storedCommodityRepository;
    }

    public function validate(RuleInterface $rule): bool
    {
        if (!$rule instanceof MustContainCommodityInStorageRule) {
            throw new UnexpectedTypeException($rule, MustContainCommodityInStorageRule::class);
        }

        return $this->storedCommodityRepository->doesStorageContainCommodity(
            $rule->getStorage(),
            $rule->getCommodity(),
            $rule->getQuantity()
        );
    }
}
