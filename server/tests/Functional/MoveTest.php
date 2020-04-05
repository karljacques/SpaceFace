<?php

namespace App\Tests\Functional;

use App\Entity\Ship;
use App\Entity\User;
use App\Tests\FixtureAwareTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class MoveTest extends GameTestCase
{
    use FixtureAwareTestCase;

    const AUTH_TOKEN = '73d0e731888687f8dd1413215b5de938';

    /** @var KernelBrowser */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->executeFixtures();
    }

    public function testInvalidMovementDirection()
    {
        $response = $this->executeCommand('backwards');

        $this->assertFalse($response->success);
        $this->assertIsArray($response->errors);

        $error = $response->errors[0];


        $this->assertObjectHasAttribute('type', $error);
        $this->assertEquals('validation', $error->type);

        $this->assertObjectHasAttribute('property', $error);
        $this->assertEquals('direction', $error->property);

        $this->assertEquals('Does not have a value in the enumeration ["up","down","left","right"]', $error->message);
    }

    public function testOutOfBoundsMovement()
    {
        $response = $this->executeCommand('down');

        $this->assertFalse($response->success);

        $this->assertIsArray($response->errors);

        $error = $response->errors[0];
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

