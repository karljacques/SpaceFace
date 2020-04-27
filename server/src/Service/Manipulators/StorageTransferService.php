<?php


namespace App\Service\Manipulators;


use App\Entity\Commodity;
use App\Entity\Component\Storage;

class StorageTransferService
{
    protected StorageManipulatorService $storageManipulatorService;

    public function __construct(StorageManipulatorService $manipulatorService)
    {
        $this->storageManipulatorService = $manipulatorService;
    }

    public function transferCommodity(Commodity $commodity, Storage $origin, Storage $destination, int $quantity): void
    {
        $this->storageManipulatorService->removeCommodity($origin, $commodity, $quantity);
        $this->storageManipulatorService->addCommodity($destination, $commodity, $quantity);
    }
}
