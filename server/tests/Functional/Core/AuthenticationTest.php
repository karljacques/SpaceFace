<?php


namespace App\Tests\Functional\Core;


use App\DataFixtures\UserFixtures;
use App\Tests\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie as BrowserKitCookie;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationTest extends WebTestCase
{
    use FixtureAwareTestCase;

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        /** @var UserFixtures $userFixtures */
        $userFixtures = static::$container->get(UserFixtures::class);
        $this->addFixture($userFixtures);

        $this->executeFixtures();
    }

    public function testPermissionDeniedWhenUnauthenticated()
    {
        $this->client->request('POST', '/move');
        $response = $this->client->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testAuthenticationCheckEndpointReturnsFalseWhenUnauthenticated()
    {
        $this->client->request('GET', '/authenticated');
        $response = $this->client->getResponse();

        $this->assertIsAuthenticated($response, false);
    }

    /**
     * @param Response $response
     * @param bool $isAuthenticated
     */
    protected function assertIsAuthenticated(Response $response, bool $isAuthenticated = true): void
    {
        $this->assertEquals(200, $response->getStatusCode());

        $json = $response->getContent();
        $this->assertJson($json);
        $data = json_decode($json);

        $this->assertEquals($isAuthenticated, $data->authenticated);
    }

    public function testLoginSendsJWTCookie()
    {
        $this->markTestIncomplete('JWT Cookie Authentication needs fixed in CI');
        $body = json_encode([
            'username' => 'TestUser',
            'password' => 'password'
        ]);

        $this->client->request('POST', '/login', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], $body);

        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        /** @var Cookie $cookie */
        $cookie = collect($response->headers->getCookies())
            ->first(fn(Cookie $cookie) => $cookie->getName() === 'AUTHENTICATION_JWT');

        $this->assertNotNull($cookie);

        $browserKitCookie = new BrowserKitCookie($cookie->getName(), $cookie->getValue());

        $this->client->getCookieJar()->set($browserKitCookie);
        $this->client->request('GET', '/authenticated', [], [], []);
        $response = $this->client->getResponse();

        $this->assertIsAuthenticated($response);
    }
}
