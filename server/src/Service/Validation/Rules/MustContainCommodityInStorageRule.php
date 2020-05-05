<?php


namespace App\Service\Validation\Rules;


use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Repository\Join\StoredCommodityRepository;

class MustContainCommodityInStorageRule implements RuleInterface
{
    private Storage $storage;
    private Commodity $commodity;
    private int $quantity;
    private StoredCommodityRepository $storedCommodityRepository;

    // This is a bit rank, eventually split Rules -> RuleValidators. So much code.
    public function __construct(StoredCommodityRepository $storedCommodityRepository, Storage $storage, Commodity $commodity, int $quantity)
    {
        $this->storage = $storage;
        $this->commodity = $commodity;
        $this->quantity = $quantity;
        $this->storedCommodityRepository = $storedCommodityRepository;
    }

    public function getViolationMessage(): string
    {
        return 'Storage does not have enough';
    }

    public function validate(): bool
    {
        return $this->storedCommodityRepository->doesStorageContainCommodity(
            $this->storage,
            $this->commodity,
            $this->quantity
        );
    }
}
