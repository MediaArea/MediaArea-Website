<?php

namespace MediaInfoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SupportControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFaq()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/FAQ');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormats()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/Formats');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTags()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/Tags');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testBuild()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/Build_From_Sources');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testBuilMediaInfoLib()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Support/Build_From_Sources/MediaInfoLib');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
