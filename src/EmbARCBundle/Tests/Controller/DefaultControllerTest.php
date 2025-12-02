<?php

namespace EmbARCBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/embARC');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('embARC', $crawler->filter('h1')->text());
        $this->assertEquals('embARC', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/embARC/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
