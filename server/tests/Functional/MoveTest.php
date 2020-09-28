<?php

namespace App\Tests\Functional;

use App\Tests\FixtureAwareTestCase;
use App\Util\HexVector;
use Generator;
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
        $response = $this->executeCommand(new HexVector(3, 4));

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
        $system = $this->getCurrentShip()->getSystem();
        $this->getCurrentShip()->setVector(new HexVector($system->getSizeX(), $system->getSizeY()));

        $response = $this->executeCommand(new HexVector(1, 0));

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

        $response = $this->executeCommand(new HexVector(1, 0));

        $this->assertFalse($response->success);

        $this->assertTrue($ship->getVector()->equals(new HexVector(1, 1)));
    }

    /**
     * @dataProvider movementDataProvider
     *
     * @param HexVector $direction
     * @param bool $success
     */
    public function testMoveDirections(HexVector $direction, bool $success)
    {
        $this->getCurrentShip()->setVector(new HexVector(0, 0));
        $response = $this->executeCommand($direction);

        $this->assertEquals($success, $response->success);


        if ($success) {
            $this->assertIsObject($response->data);

            $ship = $this->getCurrentShip();

            $this->assertEquals($direction->getR(), $ship->getY());
            $this->assertEquals($direction->getQ(), $ship->getX());
        }
    }

    public function movementDataProvider(): Generator
    {
        yield [
            'direction' => new HexVector(1, -1),
            'valid' => true
        ];

        yield [
            'direction' => new HexVector(1, 0),
            'valid' => true
        ];

        yield [
            'direction' => new HexVector(0, 1),
            'valid' => true
        ];

        yield [
            'direction' => new HexVector(-1, 1),
            'valid' => true
        ];

        yield [
            'direction' => new HexVector(-1, 0),
            'valid' => true
        ];

        yield [
            'direction' => new HexVector(0, -1),
            'valid' => true
        ];

        // Invalid
        yield [
            'direction' => new HexVector(1, 1),
            'valid' => false
        ];

        yield [
            'direction' => new HexVector(-1, -1),
            'valid' => false
        ];
    }

    protected function executeCommand(HexVector $direction): object
    {
        $body = json_encode([
            'direction' => [
                'x' => $direction->getQ(),
                'y' => $direction->getR()
            ]
        ]);

        $this->client->request('POST', '/move', [], [], [], $body);

        return json_decode($this->client->getResponse()->getContent());
    }
}

