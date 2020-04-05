<?php


namespace App\Tests\Functional;

use App\DataFixtures\ShipFixtures;
use App\Tests\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameTestCase extends WebTestCase
{
    use FixtureAwareTestCase;

    const AUTH_TOKEN = '73d0e731888687f8dd1413215b5de938';

    /** @var KernelBrowser */
    protected $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        /** @var ShipFixtures $shipFixtures */
        $shipFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\ShipFixtures');
        $this->addFixture($shipFixtures);
    }
}
