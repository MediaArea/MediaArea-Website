<?php

namespace Tests\AppBundle\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testMediaInfoPageDoesNotExist()
    {
        $client = static::createClient();

        // Without locale
        $client->request('GET', '/MediaInfo/DoesNotExist');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo/DoesNotExist'));

        // With locale
        $client->request('GET', '/en/MediaInfo/DoesNotExist');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/en/MediaInfo'));
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
            ['/'],
            ['/en/Repos'],
            ['/Services'],
            ['/Events'],
            ['/Conduct'],
            ['/TeamRules'],
            ['/Legal'],
            ['/Privacy'],
            ['/AudioChannelLayout'],
            ['/en/DIVX'],
            ['/en/DX50'],
            ['/en/XVID'],
        ];
    }
}
