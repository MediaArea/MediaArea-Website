<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MediaInfoDefaultControllerTest extends WebTestCase
{
    public function testAbout()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/MediaInfo');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Without locale and trailing slash
        $client->request('GET', '/MediaInfo/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        // With valid locale
        $client->request('GET', '/en/MediaInfo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/en/MediaInfo/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        // With invalid locale
        $client->request('GET', '/zz/MediaInfo');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/zz/MediaInfo/');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));

        $client->request('GET', '/zz/MediaInfo/Support/Tags');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/Support/Tags'));

        $client->request('GET', '/qwerty123/MediaInfo');
        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));
    }

    public function testScreenshots()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Screenshots');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDonate()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Donate');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTestimonials()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/Testimonials');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLicense()
    {
        $client = static::createClient();

        $client->request('GET', '/en/MediaInfo/License');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
