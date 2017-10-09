<?php

namespace MOVMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/MOVMetaEdit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MOV MetaEdit', $crawler->filter('h1')->text());
        $this->assertEquals('MOV MetaEdit', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/MOVMetaEdit/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
