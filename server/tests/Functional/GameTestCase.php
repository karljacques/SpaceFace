<?php


namespace App\Tests\Functional;

use App\DataFixtures\ShipFixtures;
use App\Entity\Ship;
use App\Entity\User;
use App\Tests\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameTestCase extends WebTestCase
{
    use FixtureAwareTestCase;

    const AUTH_TOKEN = '73d0e731888687f8dd1413215b5de938';

    /** @var KernelBrowser */
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        /** @var ShipFixtures $shipFixtures */
        $shipFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\ShipFixtures');
        $this->addFixture($shipFixtures);
    }

    /**
     * @return User
     */
    protected function getCurrentUser(): User
    {
        /** @var User $user */
        $user = $this->getRepository(User::class)->findOneBy(['apiToken' => self::AUTH_TOKEN]);
        return $user;
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getShipFromUser(User $user): Ship
    {
        return $user->getCharacters()->first()->getShips()->first();
    }

    /**
     * @return Ship
     */
    protected function getCurrentShip(): Ship
    {
        $user = $this->getCurrentUser();

        /** @var Ship $ship */
        $ship = $this->getShipFromUser($user);
        return $ship;
    }
}
