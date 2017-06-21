<?php

namespace DVAnalyzerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DVAnalyzer');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('DV Analyzer', $crawler->filter('h1')->text());
        $this->assertEquals('DV Analyzer', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testLicense()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/DVAnalyzer/License');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
