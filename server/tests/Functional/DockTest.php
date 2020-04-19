<?php


namespace App\Tests\Functional;


use App\DataFixtures\DockableFixtures;
use App\Entity\Dockable;
use App\Tests\Helpers\LocationHelper;

class DockTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(DockableFixtures::class);
        $this->executeFixtures();
    }

    public function testDockWhenNotInSameLocation()
    {
        $dockable = $this->findFirstDockable();
        $ship = $this->getCurrentShip();

        $ship->setLocation(LocationHelper::offsetLocation($dockable->getLocation()));

        $this->flush();

        $result = $this->executeCommand($dockable->getId());

        $this->assertFalse($result->success);
        $this->assertNull($ship->getDockedAt());

    }

    public function testDockWhenDocked()
    {
        $dockable = $this->findFirstDockable();
        $ship = $this->getCurrentShip();

        $ship->setDockedAt($dockable);

        $ship->setLocation($dockable->getLocation());
        $result = $this->executeCommand($dockable->getId());

        $this->assertFalse($result->success);
        $this->assertEquals($dockable, $ship->getDockedAt());
    }

    public function testDockSuccessful()
    {
        $dockable = $this->findFirstDockable();
        $ship = $this->getCurrentShip();

        $ship->setLocation($dockable->getLocation());
        $result = $this->executeCommand($dockable->getId());

        $this->assertTrue($result->success);
        $this->assertEquals($dockable, $ship->getDockedAt());
    }


    protected function findFirstDockable(): Dockable
    {
        return collect($this->getRepository(Dockable::class)->findAll())->first();
    }


    protected function executeCommand(int $dockable): object
    {
        $body = json_encode([
            'dockable' => $dockable
        ]);

        $uri = '/dock';

        return $this->sendCommandRequest($uri, $body);
    }
}
