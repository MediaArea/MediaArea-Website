<?php

namespace DVRescueBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DVRescue');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('DVRescue', $crawler->filter('h1')->text());
        $this->assertEquals('DVRescue', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DVRescue/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMan()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DVRescue/man');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
