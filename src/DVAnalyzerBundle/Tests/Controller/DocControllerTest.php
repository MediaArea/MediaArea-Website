<?php

namespace DVAnalyzerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocControllerTest extends WebTestCase
{
    public function testMetadata()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/dv-metadata');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAnalyze()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/what-does-it-analyze');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testVideoErrors()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/dv-video-error-concealment');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAudioErrors()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/audio-errors');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDifIncoherency()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/dif-incoherency');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSttsFluctuation()
    {
        $client = static::createClient();

        $client->request('GET', '/DVAnalyzer/stts-fluctuation');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
