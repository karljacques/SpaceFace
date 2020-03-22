<?php


use App\Tests\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoveTest extends WebTestCase
{
    use FixtureAwareTestCase;

    const AUTH_TOKEN = '73d0e731888687f8dd1413215b5de938';

    /** @var KernelBrowser */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->addFixture(static::$kernel->getContainer()->get('test.App\DataFixtures\ShipFixtures'));
        $this->executeFixtures();

    }

    public function testInvalidMovementDirection()
    {
        $body = json_encode([
            'direction' => 'backwards'
        ]);

        $this->client->request('POST', '/move', [], [], [
            'HTTP_X-AUTH-TOKEN' => self::AUTH_TOKEN
        ], $body);

        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertFalse($response->success);
        $this->assertObjectHasAttribute('direction', $response->errors);
    }
}
