<?php

namespace UserBundle\Tests\Controller;

class SecurityControllerTest extends UserAbstractControllerTest
{
    public function testLogInInNavNotConnected()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals('Log in', trim($crawler->filter('#main-navbar .navbar-right li a')->text()));
    }

    public function testLogInInNavConnected()
    {
        $client = $this->createRegularUserClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(
            'Logged in as test@mediaarea.net',
            trim($crawler->filter('#main-navbar .navbar-right li a')->text())
        );
    }

    public function testLoginNotConnected()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLoginConnected()
    {
        $client = $this->createRegularUserClient();

        $client->request('GET', '/login');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/profile/'));
    }
}
