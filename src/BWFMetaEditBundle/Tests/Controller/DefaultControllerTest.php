<?php

namespace BWFMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('BWF MetaEdit', $crawler->filter('h1')->text());
        $this->assertEquals('BWF MetaEdit', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/BWFMetaEdit/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
