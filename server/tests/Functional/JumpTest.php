<?php

namespace App\Tests\Functional;

use App\DataFixtures\ShipFixtures;

class JumpTest extends GameTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        /** @var ShipFixtures $jumpNodeFixtures */
        $jumpNodeFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\JumpNodeFixtures');
        $this->addFixture($jumpNodeFixtures);

        $this->executeFixtures();
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
