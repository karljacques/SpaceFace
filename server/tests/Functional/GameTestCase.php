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

    /** @var KernelBrowser */
    protected KernelBrowser $client;

    protected User $loggedInUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();


        /** @var ShipFixtures $shipFixtures */
        $shipFixtures = static::$kernel->getContainer()->get('test.App\DataFixtures\ShipFixtures');
        $this->addFixture($shipFixtures);

        $this->executeFixtures();
    }

    protected function loginUser(): void
    {
        $user = collect($this->getRepository(User::class)->findBy([], ['id' => 'asc'], 1))->first();
        $this->assertNotNull($user);

        $this->loggedInUser = $user;
        $this->client->loginUser($user);
    }

    /**
     * @return User
     */
    protected function getCurrentUser(): User
    {
        return $this->loggedInUser;
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

    /**
     * @param string $uri
     * @param string $body
     * @return mixed
     */
    protected function sendCommandRequest(string $uri, ?string $body)
    {
        $this->client->request('POST', $uri, [], [], [], $body);

        return json_decode($this->client->getResponse()->getContent());
    }

    protected function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    protected function findFirst(string $class)
    {
        return collect($this->getRepository($class)->findAll())->first();
    }
}
