<?php

namespace MediaInfoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZZLastControllerTest extends WebTestCase
{
    public function testLocaleRedirect()
    {
        $client = static::createClient();

        $client->request('GET', '/MediaInfo');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/MediaInfo/Download');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download'));

        $client->request('GET', '/MediaInfo/Download/Ubuntu');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download/Ubuntu'));
    }

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

        $client->request('GET', '/MI/Download/Ubuntu');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download/Ubuntu'));

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

        $client->request('GET', '/en/MI/Download/Ubuntu');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download/Ubuntu'));
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
