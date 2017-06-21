<?php

namespace QCToolsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocControllerTest extends WebTestCase
{
    public function testGettingStarted()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/Getting_Started');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testHowToUse()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/How_To_Use');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFilterDescriptions()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/Filter_Descriptions');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPlaybackFilters()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/Playback_Filters');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRecording()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/Recording');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSeattle()
    {
        $client = static::createClient();

        $client->request('GET', '/QCTools/Seattle_Municipal_Archives_Manual');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
