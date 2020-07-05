<?php

namespace App\Tests\Functional;

use App\Tests\FixtureAwareTestCase;
use App\Util\Vector2;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class MoveTest extends GameTestCase
{
    use FixtureAwareTestCase;

    /** @var KernelBrowser */
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->executeFixtures();

        $this->loginUser();
    }

    public function testInvalidMovementDirection()
    {
        $response = $this->executeCommand(new Vector2(3, 4));

        $this->assertFalse($response->success);
        $this->assertIsArray($response->errors);

        $error = $response->errors[0];


        $this->assertObjectHasAttribute('type', $error);
        $this->assertEquals('validation', $error->type);

        $this->assertObjectHasAttribute('property', $error);
        $this->assertEquals('direction', $error->property);

        $this->assertEquals('The direction supplied is not valid', $error->message);
    }

    public function testOutOfBoundsMovement()
    {
        $response = $this->executeCommand(new Vector2(-1, 0));

        $this->assertFalse($response->success);

        $this->assertIsArray($response->errors);

        $error = $response->errors[0];
        $this->assertObjectHasAttribute('type', $error);
        $this->assertEquals('action', $error->type);

        $this->assertObjectHasAttribute('message', $error);
        $this->assertEquals('Proposed location is out of system bounds', $error->message);

//        $this->assertObjectHasAttribute('current_position', $error->details);
//        $this->assertObjectHasAttribute('delta', $error->details);
//        $this->assertObjectHasAttribute('proposed_position', $error->details);
    }

    public function testNotEnoughFuelToMove()
    {
        $ship = $this->getCurrentShip();
        $ship->setFuel(0);

        $response = $this->executeCommand(new Vector2(1, 0));

        $this->assertFalse($response->success);

        $this->assertTrue($ship->getVector()->equals(new Vector2(1, 1)));
    }

    public function testSuccessfulMove()
    {
        $response = $this->executeCommand(new Vector2(1, 0));

        $this->assertTrue($response->success);

        $this->assertIsObject($response->data);

        $ship = $this->getCurrentShip();

        $this->assertEquals(1, $ship->getY());
        $this->assertEquals(2, $ship->getX());
    }

    protected function executeCommand(Vector2 $direction): object
    {
        $body = json_encode([
            'direction' => [
                'x' => $direction->getX(),
                'y' => $direction->getY()
            ]
        ]);

        $this->client->request('POST', '/move', [], [], [], $body);

        return json_decode($this->client->getResponse()->getContent());
    }

}

