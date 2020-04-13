<?php


namespace App\Service\Manipulators;


use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Entity\Join\StoredCommodity;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;

class StorageManipulatorService
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addCommodity(Storage $storage, Commodity $commodity, int $quantity): StoredCommodity
    {
        $storedCommodity = $this->findStoredCommodity($storage, $commodity);

        if ($storedCommodity) {
            $storedCommodity->setQuantity($storedCommodity->getQuantity() + $quantity);
        } else {
            $storedCommodity = new StoredCommodity();
            $storedCommodity->setQuantity($quantity);

            $this->entityManager->persist($storedCommodity);

            $storedCommodity->setCommodity($commodity);
            $storage->addStoredCommodity($storedCommodity);
        }

        return $storedCommodity;
    }

    public function removeCommodity(Storage $storage, Commodity $commodity, int $quantity): void
    {
        $storedCommodity = $this->findStoredCommodity($storage, $commodity);

        if ($storedCommodity === null) {
            throw new LogicException();
        }

        $newQuantity = $storedCommodity->getQuantity() - $quantity;

        $this->modifyCommodityQuantity($storedCommodity, $newQuantity);
    }

    protected function deleteStoredCommodity(StoredCommodity $storedCommodity): void
    {
        $this->entityManager->remove($storedCommodity);
    }

    protected function modifyCommodityQuantity(StoredCommodity $storedCommodity, int $newQuantity): void
    {
        if ($newQuantity <= 0) {
            $this->deleteStoredCommodity($storedCommodity);
        } else {
            $storedCommodity->setQuantity($newQuantity);
        }
    }

    protected function findStoredCommodity(Storage $storage, Commodity $commodity): ?StoredCommodity
    {
        return $storage->getStoredCommodities()
            ->filter(fn(StoredCommodity $storedCommodity) => $storedCommodity->getCommodity()->getId() === $commodity->getId())
            ->first() ?: null;
    }
}
