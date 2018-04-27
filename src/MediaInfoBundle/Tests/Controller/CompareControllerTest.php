<?php

namespace MediaInfoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompareControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/MediaCompare');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MediaCompare - Compare multiple files with MediaInfo', $crawler->filter('h1')->text());
        $this->assertEquals('MediaInfo', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }
}
