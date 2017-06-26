<?php

namespace AVIMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AVI MetaEdit', $crawler->filter('h1')->text());
        $this->assertEquals('AVI MetaEdit', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/AVIMetaEdit/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
