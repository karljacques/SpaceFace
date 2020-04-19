<?php

namespace App\Tests\Functional;

use App\DataFixtures\JumpNodeFixtures;
use App\Entity\JumpNode;
use App\Repository\JumpNodeRepository;
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
        $node = $this->getFirstNode();

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
        $node = $this->getFirstNode();
        $ship = $this->getCurrentShip();

        $ship->setLocation($node->getExitLocation());

        $this->getEntityManager()->flush();

        $response = $this->makeRequest($node->getId());

        $this->assertFalse($response->success);
    }

    public function testJumpNotAllowedFromAdjacentSector()
    {
        $node = $this->getFirstNode();
        $ship = $this->getCurrentShip();

        $ship->setLocation(LocationHelper::offsetLocation($node->getLocation()));

        $this->getEntityManager()->flush();

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

        $this->client->request('POST', '/jump', [], [], [
            'HTTP_X-AUTH-TOKEN' => self::AUTH_TOKEN
        ], $body);

        return json_decode($this->client->getResponse()->getContent());
    }

    /**
     * @return JumpNode
     */
    protected function getFirstNode(): JumpNode
    {
        /** @var JumpNodeRepository $jumpNodeRepository */
        $jumpNodeRepository = $this->getRepository(JumpNode::class);

        /** @var JumpNode $node */
        $node = collect($jumpNodeRepository->findAll())->first();
        return $node;
    }
}
