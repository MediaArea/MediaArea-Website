<?php

namespace Tests\MediaInfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DownloadControllerTest extends WebTestCase
{
    public function testDownload()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/MediaInfo/Download');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download'));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // With valid locale
        $client->request('GET', '/en/MediaInfo/Download');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // With invalid locale
        $client->request('GET', '/zz/MediaInfo/Download');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Download'));
    }

    public function testAppimage()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/AppImage');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFlatpak()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Flatpak');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testArch()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Arch_Linux');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCentos()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/CentOS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDebian()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Debian');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFedora()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Fedora');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGentoo()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Gentoo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMac()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Mac_OS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMageia()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Mageia');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testMandriva()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Mandriva');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testManjaro()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Manjaro');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testOpensuse()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/openSUSE');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPclinuxos()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/PCLinuxOS');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRhel()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/RHEL');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSlackware()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Slackware');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSle()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/SLE');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSnapshots()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Snapshots');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSolaris()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Solaris');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSource()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Source');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUbuntu()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Ubuntu');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testWindows()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Download/Windows');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
