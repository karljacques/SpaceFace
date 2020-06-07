<?php

namespace App\Tests\Functional;

use App\DataFixtures\JumpNodeFixtures;
use App\Entity\JumpNode;
use App\Tests\Helpers\LocationHelper;

class JumpTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /** @var JumpNodeFixtures $jumpNodeFixtures */
        $jumpNodeFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\JumpNodeFixtures');
        $this->addFixture($jumpNodeFixtures);

        $this->executeFixtures();
    }

    public function testJumpWhenAtEntryNode()
    {
        /** @var JumpNode $node */
        $node = $this->findFirst(JumpNode::class);

        $ship = $this->getCurrentShip();
        $ship->setLocation($node->getLocation());

        $this->getEntityManager()->flush();

        $response = $this->makeRequest($node->getId());

        $this->assertTrue($response->success);

        $this->getEntityManager()->refresh($ship);

        $this->assertTrue($ship->getLocation()->equals($node->getExitLocation()));
    }

    public function testJumpNotAllowedFromExitNode()
    {
        /** @var JumpNode $node */
        $node = $this->findFirst(JumpNode::class);
        $ship = $this->getCurrentShip();

        $ship->setLocation($node->getExitLocation());

        $this->getEntityManager()->flush();

        $response = $this->makeRequest($node->getId());

        $this->assertFalse($response->success);
    }

    public function testJumpNotAllowedFromAdjacentSector()
    {
        $node = $this->findFirst(JumpNode::class);
        $ship = $this->getCurrentShip();

        $ship->setLocation(LocationHelper::offsetLocation($node->getLocation()));

        $response = $this->makeRequest($node->getId());

        $this->assertFalse($response->success);
    }

    /**
     * @param int $nodeId
     * @return object
     */
    public function makeRequest(int $nodeId): object
    {
        $body = json_encode([
            "node" => $nodeId
        ]);

        $uri = '/jump';

        return $this->sendCommandRequest($uri, $body);
    }
}
