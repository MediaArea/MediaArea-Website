<?php

namespace NoTimeToWaitBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/NoTimeToWait');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('No Time To Wait', $crawler->filter('h1')->text());
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
            ['/NoTimeToWait'],
            ['/NoTimeToWait1'],
            ['/NoTimeToWait2'],
            ['/NoTimeToWait3'],
            ['/QCWorkshop2018'],
            ['/NoTimeToWait4'],
            ['/NoTimeToWait5'],
            ['/NoTimeToWait6'],
            ['/NoTimeToWait7'],
        ];
    }
}
