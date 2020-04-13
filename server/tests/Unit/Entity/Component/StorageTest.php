<?php


namespace App\Tests\Unit\Entity\Component;


use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Entity\Join\StoredCommodity;

use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    public function testGetCapacity()
    {
        $storage = new Storage();
        $storage->setCapacity(1000);

        $this->assertEquals(1000, $storage->getCapacity());
        $this->assertEquals(1000, $storage->getFreeCapacity());
    }

    public function testCapacityUsage()
    {
        $commodity = new Commodity();
        $commodity->setSize(2);
        $commodity->setWeight(400);

        $storage = new Storage();
        $storage->setCapacity(1000);

        $storedCommodity = new StoredCommodity();
        $storedCommodity
            ->setQuantity(3)
            ->setCommodity($commodity);

        $storage->addStoredCommodity($storedCommodity);

        $usage = $storage->getCapacityUsage();
        $this->assertEquals(6, $usage);
        $this->assertEquals(994, $storage->getFreeCapacity());

        $this->assertEquals(1200, $storage->getWeight());

    }
}
