<?php

namespace MOVMetaEditBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DownloadControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testArch()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Arch_Linux');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCentos()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/CentOS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDebian()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Debian');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFedora()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Fedora');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFlatpak()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Flatpak');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMac()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Mac_OS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMageia()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Mageia');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testOpensuse()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/openSUSE');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRhel()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/RHEL');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSle()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/SLE');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSource()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Source');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUbuntu()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Ubuntu');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWindows()
    {
        $client = static::createClient();

        $client->request('GET', '/MOVMetaEdit/Download/Windows');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
