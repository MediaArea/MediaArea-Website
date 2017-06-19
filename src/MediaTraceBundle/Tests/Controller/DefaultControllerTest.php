<?php

namespace MediaTraceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/MediaTrace/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MediaTrace', $crawler->filter('h1')->text());
    }
}
