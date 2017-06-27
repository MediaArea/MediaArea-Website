<?php

namespace Tests\MediaInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZZLastControllerTest extends WebTestCase
{
    public function testMIRedirect()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/MI');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/MI/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/MI/Download');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download'));

        // With locale
        $client->request('GET', '/en/MI');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/en/MI/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/en/MI/Download');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download'));
    }

    public function testNotFound()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/test');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
