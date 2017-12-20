<?php

namespace MediaInfoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OnlineControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/MediaInfoOnline');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MediaInfoOnline - MediaInfo in your browser!', $crawler->filter('h1')->text());
    }
}
