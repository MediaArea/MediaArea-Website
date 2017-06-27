<?php

namespace Tests\MediaInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SupportSDKControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testfaqReadFirst()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/ReadFirst');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMeans()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/Means');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testQuickStart()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/Quick_Start');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMoreInfo()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/More_Info');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testBuffers()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/Buffers');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDuplicate()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/Duplicate');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFiltering()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/SDK/Filtering');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
