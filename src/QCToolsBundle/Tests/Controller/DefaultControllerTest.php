<?php

namespace QCToolsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/QCTools');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('QCTools', $crawler->filter('h1')->text());
        $this->assertEquals('QCTools', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/QCTools/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
