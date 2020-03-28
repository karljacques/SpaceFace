<?php

namespace App\Tests\Functional;

use App\DataFixtures\ShipFixtures;
use App\Entity\System;
use Doctrine\ORM\EntityManagerInterface;

class JumpTestCase extends GameTestCase
{
    public function setUp()
    {
        parent::setUp();

        /** @var ShipFixtures $jumpNodeFixtures */
        $jumpNodeFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\JumpNodeFixtures');
        $this->addFixture($jumpNodeFixtures);

        $this->executeFixtures();
    }

    public function testSystemDoesNotExist()
    {
        $systemId = $this->findUnusedSystemId();

        $response = $this->makeRequest($systemId, 1, 1);

        $this->assertFalse($response->success);
        $this->assertObjectHasAttribute('error', $response);

        $this->assertEquals('action', $response->error->type);
        $this->assertEquals('System does not exist', $response->error->message);

    }

    private function findUnusedSystemId(): int
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $systems = $entityManager->getRepository(System::class)->findAll();

        $existingSystemIds = array_map(function (System $system) {
            return $system->getId();
        }, $systems);

        $systemId = null;
        for ($i = 0; $i < 2147483647; $i++) {
            if (!in_array($i, $existingSystemIds)) {
                $systemId = $i;
                break;
            }
        }

        if (null === $systemId) {
            throw new LogicException();
        }

        return $systemId;
    }

    /**
     * @param int|null $systemId
     * @param int $x
     * @param int $y
     * @return object
     */
    public function makeRequest(?int $systemId, int $x, int $y): object
    {
        $body = json_encode([
            "target" => [
                "system" => $systemId,
                "x" => $x,
                "y" => $y
            ]
        ]);

        $this->client->request('POST', '/jump', [], [], [
            'HTTP_X-AUTH-TOKEN' => self::AUTH_TOKEN
        ], $body);

        $response = json_decode($this->client->getResponse()->getContent());
        return $response;
    }


}
