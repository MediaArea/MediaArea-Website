<?php

namespace MediaConchOnlineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/MediaConchOnline/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, $crawler->filter('h1:contains("MediaConchOnline")'));
    }

    public function testAdmin()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }
}
