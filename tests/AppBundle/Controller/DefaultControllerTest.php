<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomeMediaArea()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testMediaInfoPageDoesNotExist()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/MediaInfo/DoesNotExist');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // With locale
        $client->request('GET', '/en/MediaInfo/DoesNotExist');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testMediaInfoAcceptLanguage()
    {
        // With valid language
        $client = static::createClient();
        $client->request(
            'GET',
            '/MediaInfo',
            array(),
            array(),
            array('HTTP_ACCEPT_LANGUAGE' => 'fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3')
        );
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/fr/MediaInfo'));

        // With invalid language
        $client = static::createClient();
        $client->request('GET', '/MediaInfo', array(), array(), array('HTTP_ACCEPT_LANGUAGE' => 'zz'));
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRepos()
    {
        $client = static::createClient();

        $client->request('GET', '/en/Repos');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEvents()
    {
        $client = static::createClient();

        $client->request('GET', '/Events');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testdivx()
    {
        $client = static::createClient();

        $client->request('GET', '/en/DIVX');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testdx50()
    {
        $client = static::createClient();

        $client->request('GET', '/en/DX50');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testxvid()
    {
        $client = static::createClient();

        $client->request('GET', '/en/XVID');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
