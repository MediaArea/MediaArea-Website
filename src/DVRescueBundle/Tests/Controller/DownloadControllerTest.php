<?php

namespace DVRescueBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DownloadControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/DVRescue/Download');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMac()
    {
        $client = static::createClient();

        $client->request('GET', '/DVRescue/Download/Mac_OS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSource()
    {
        $client = static::createClient();

        $client->request('GET', '/DVRescue/Download/Source');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWindows()
    {
        $client = static::createClient();

        $client->request('GET', '/DVRescue/Download/Windows');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
