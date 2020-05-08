<?php


namespace App\Service\Validation\Rules\Storage;


use App\Entity\Component\Storage;
use App\Service\Validation\Rules\RuleInterface;

class MustHaveStorageSpaceRule implements RuleInterface
{
    private Storage $storage;
    private int $storageRequired;

    public function __construct(Storage $storage, int $storageRequired)
    {
        $this->storage = $storage;
        $this->storageRequired = $storageRequired;
    }

    public function getViolationMessage(): string
    {
        return 'You do not have enough storage space';
    }

    /**
     * @return Storage
     */
    public function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * @return int
     */
    public function getStorageRequired(): int
    {
        return $this->storageRequired;
    }


}
