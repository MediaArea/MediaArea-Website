<?php

namespace LeaveSDBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/LeaveSD');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('LeaveSD', $crawler->filter('h1')->text());
        $this->assertEquals('LeaveSD', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/LeaveSD/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
