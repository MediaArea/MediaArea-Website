<?php

namespace RAWcookedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/RAWcooked');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('RAWcooked', $crawler->filter('h1')->text());
        $this->assertEquals('RAWcooked', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }
}
