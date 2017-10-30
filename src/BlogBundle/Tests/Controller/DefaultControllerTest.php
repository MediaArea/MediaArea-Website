<?php

namespace BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MediaArea blog', $crawler->filter('h1')->text());
        $this->assertEquals(2, $crawler->filter('div.content h2')->count());

        $firstLink = $crawler->filter('div.content h2 a')->first()->link();
        $this->assertEquals(
            'http://localhost/blog/2017/09/07/interview-with-ben-turkus-genevieve-havemeyer-king-nypl',
            $firstLink->getUri()
        );

        $crawler = $client->click($firstLink);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            'Interview with Ben Turkus and Genevieve Havemeyer-King of NYPL',
            $crawler->filter('h1')->text()
        );
    }

    public function testPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/blog/2017/08/22/interview-with-julia-kim');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Interview with Julia Kim', $crawler->filter('h1')->text());
    }
}
