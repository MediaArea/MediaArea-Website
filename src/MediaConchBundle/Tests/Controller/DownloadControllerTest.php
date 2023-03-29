<?php

namespace MediaConchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DownloadControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testResponse200($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return [
            ['/MediaConch/Download'],
            ['/MediaConch/Download/Flatpak'],
            ['/MediaConch/Download/AppImage'],
            ['/MediaConch/Download/Arch_Linux'],
            ['/MediaConch/Download/CentOS'],
            ['/MediaConch/Download/Debian'],
            ['/MediaConch/Download/Raspbian'],
            ['/MediaConch/Download/Fedora'],
            ['/MediaConch/Download/Mac_OS'],
            ['/MediaConch/Download/Mageia'],
            ['/MediaConch/Download/openSUSE'],
            ['/MediaConch/Download/RHEL'],
            ['/MediaConch/Download/RockyLinux'],
            ['/MediaConch/Download/SLE'],
            ['/MediaConch/Download/Source'],
            ['/MediaConch/Download/Snapshots'],
            ['/MediaConch/Download/Ubuntu'],
            ['/MediaConch/Download/Windows'],
            ['/MediaConch/Download/Lambda'],
            ['/MediaConch/Download/JavaScript'],
        ];
    }
}
