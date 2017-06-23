<?php

namespace OllistdBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ollistd');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Open LossLess in STanDards', $crawler->filter('h1')->text());
        $this->assertEquals(
            'Open LossLess in STanDards',
            trim($crawler->filter('#main-navbar ul.nav li.active a')->text())
        );
    }

    public function testContributing()
    {
        $client = static::createClient();

        $client->request('GET', '/ollistd/Contributing');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMp4raFFV1()
    {
        $client = static::createClient();

        $client->request('GET', '/ollistd/mp4ra_FFV1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMXFFFV1()
    {
        $client = static::createClient();

        $client->request('GET', '/ollistd/MXF_FFV1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMXFFLAC()
    {
        $client = static::createClient();

        $client->request('GET', '/ollistd/MXF_FLAC');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
