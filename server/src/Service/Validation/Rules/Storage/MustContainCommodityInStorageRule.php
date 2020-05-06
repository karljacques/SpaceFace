<?php


namespace App\Service\Validation\Rules\Storage;


use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Service\Validation\Rules\RuleInterface;

class MustContainCommodityInStorageRule implements RuleInterface
{
    private Storage $storage;
    private Commodity $commodity;
    private int $quantity;

    public function __construct(Storage $storage, Commodity $commodity, int $quantity)
    {
        $this->storage = $storage;
        $this->commodity = $commodity;
        $this->quantity = $quantity;
    }

    public function getViolationMessage(): string
    {
        return 'Storage does not have enough';
    }

    /**
     * @return Storage
     */
    public function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * @return Commodity
     */
    public function getCommodity(): Commodity
    {
        return $this->commodity;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }


}
