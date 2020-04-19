<?php


namespace App\Tests\Functional;


use App\DataFixtures\DockableFixtures;
use App\Entity\Dockable;

class UndockTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->addFixtureByName(DockableFixtures::class);
        $this->executeFixtures();
    }

    public function testUndockWhenNotDocked()
    {
        $result = $this->executeCommand();

        $this->assertFalse($result->success);
    }

    protected function executeCommand()
    {
        $uri = '/undock';

        return $this->sendCommandRequest($uri, null);
    }

    public function testSuccessfulUndock()
    {
        $ship = $this->getCurrentShip();
        $dockable = $this->findFirst(Dockable::class);

        $ship->setDockedAt($dockable);

        $result = $this->executeCommand();

        $this->assertTrue($result->success);
        $this->assertNull($ship->getDockedAt());
    }
}
