<?php

namespace App\Tests\Functional;

use App\Entity\Ship;
use App\Entity\User;
use App\Tests\FixtureAwareTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class MoveTestCase extends GameTestCase
{
    use FixtureAwareTestCase;

    const AUTH_TOKEN = '73d0e731888687f8dd1413215b5de938';

    /** @var KernelBrowser */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->executeFixtures();
    }

    public function testInvalidMovementDirection()
    {
        $response = $this->executeCommand('backwards');

        $this->assertFalse($response->success);
        $this->assertIsObject($response->error);

        $this->assertObjectHasAttribute('type', $response->error);
        $this->assertEquals('validation', $response->error->type);
        $this->assertObjectHasAttribute('violations', $response->error);

        $this->assertObjectHasAttribute('direction', $response->error->violations);
        $this->assertEquals('Value must be one of "up", "down", "left", "right"', $response->error->violations->direction);
    }

    public function testOutOfBoundsMovement()
    {
        $response = $this->executeCommand('down');

        $this->assertFalse($response->success);

        $this->assertIsObject($response->error);

        $error = $response->error;
        $this->assertObjectHasAttribute('type', $error);
        $this->assertEquals('action', $error->type);

        $this->assertObjectHasAttribute('message', $error);
        $this->assertEquals('Proposed movement is out of system bounds', $error->message);

        $this->assertObjectHasAttribute('current_position', $error->details);
        $this->assertObjectHasAttribute('delta', $error->details);
        $this->assertObjectHasAttribute('proposed_position', $error->details);
    }

    public function testSuccessfulMove()
    {
        $response = $this->executeCommand('up');

        $this->assertTrue($response->success);

        $this->assertIsObject($response->data);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        // Load user
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->findOneBy(['apiToken' => self::AUTH_TOKEN]);

        /** @var Ship $ship */
        $ship = $user->getShips()->first();

        $this->assertEquals(2, $ship->getY());
        $this->assertEquals(1, $ship->getX());
    }

    protected function executeCommand(string $direction): object
    {
        $body = json_encode([
            'direction' => $direction
        ]);

        $this->client->request('POST', '/move', [], [], [
            'HTTP_X-AUTH-TOKEN' => self::AUTH_TOKEN
        ], $body);

        return json_decode($this->client->getResponse()->getContent());
    }
}

