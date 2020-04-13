<?php


namespace App\Tests\Integration\Service;


use App\DataFixtures\Economy\CommodityFixtures;
use App\Entity\Commodity;
use App\Entity\Component\Storage;
use App\Entity\Join\StoredCommodity;
use App\Service\Manipulators\StorageManipulatorService;
use App\Tests\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StorageManipulatorServiceTest extends KernelTestCase
{
    use FixtureAwareTestCase;

    protected StorageManipulatorService $service;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $this->addFixtureByName(CommodityFixtures::class);
        $this->executeFixtures();

        $this->service = self::$kernel->getContainer()->get('test.' . StorageManipulatorService::class);
    }

    public function testAddCommodity()
    {
        $storage = $this->createStorageComponent();
        $commodity = $this->findFirstCommodity();

        $this->service->addCommodity($storage, $commodity, 1);

        $this->getEntityManager()->flush();
        $storedCommodity = $this->findStoredCommodity($commodity, $storage);

        $this->assertNotNull($storedCommodity);

        $this->assertEquals(1, $storedCommodity->getQuantity());
    }

    /**
     */
    public function testAddCommodityToAlreadyExisting()
    {
        $storage = $this->createStorageComponent();
        $commodity = $this->findFirstCommodity();

        $this->service->addCommodity($storage, $commodity, 5);
        $this->service->addCommodity($storage, $commodity, 7);

        $this->getEntityManager()->flush();

        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $this->findStoredCommodity($commodity, $storage);

        $this->assertEquals(12, $storedCommodity->getQuantity());
    }

    /**
     * @depends testAddCommodity
     */
    public function testRemoveCommodity()
    {
        $storage = $this->createStorageComponent();
        $commodity = $this->findFirstCommodity();

        $this->service->addCommodity($storage, $commodity, 5);
        $this->service->removeCommodity($storage, $commodity, 2);


        $this->getEntityManager()->flush();

        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = $this->findStoredCommodity($commodity, $storage);

        $this->assertEquals(3, $storedCommodity->getQuantity());
    }

    /**
     * @depends testAddCommodity
     */
    public function testRemoveCommodityEntirely()
    {
        $storage = $this->createStorageComponent();
        $commodity = $this->findFirstCommodity();

        $this->service->addCommodity($storage, $commodity, 5);
        $this->getEntityManager()->flush();

        $this->service->removeCommodity($storage, $commodity, 5);

        $this->getEntityManager()->flush();

        /** @var StoredCommodity|null $storedCommodity */
        $storedCommodity = $this->findStoredCommodity($commodity, $storage);

        $this->assertCount(0, $storage->getStoredCommodities());
        $this->assertNull($storedCommodity);
    }

    /**
     * @return Storage
     */
    public function createStorageComponent(): Storage
    {
        $storage = new Storage();
        $storage->setCapacity(100);

        $this->getEntityManager()->persist($storage);
        $this->getEntityManager()->flush();
        return $storage;
    }

    /**
     * @return Commodity
     */
    public function findFirstCommodity(): Commodity
    {
        return collect($this->getRepository(Commodity::class)->findAll())->first();
    }

    /**
     * @param Commodity $commodity
     * @param Storage $storage
     * @return StoredCommodity
     */
    public function findStoredCommodity(Commodity $commodity, Storage $storage): ?StoredCommodity
    {
        /** @var StoredCommodity $storedCommodity */
        $storedCommodity = collect($this->getRepository(StoredCommodity::class)->findBy([
            'commodity' => $commodity->getId(),
            'storageComponent' => $storage->getId()
        ]))->first() ?: null;

        return $storedCommodity;
    }
}
