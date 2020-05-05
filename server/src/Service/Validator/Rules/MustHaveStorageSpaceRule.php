<?php


namespace App\Service\Validator\Rules;


use App\Entity\Component\Storage;

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

    public function validate(): bool
    {
        return $this->storage->getFreeCapacity() >= $this->storageRequired;
    }
}
