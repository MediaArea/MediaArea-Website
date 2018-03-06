<?php

namespace MediaConchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/MediaConch');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(' MediaConch', $crawler->filter('h1')->text());
        $this->assertEquals('MediaConch', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

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
            ['/MediaConch/Team'],
            ['/MediaConch/Community'],
            ['/MediaConch/NoTimeToWait'],
            ['/MediaConch/NoTimeToWait2'],
        ];
    }
}
