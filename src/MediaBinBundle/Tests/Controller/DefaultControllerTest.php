<?php

namespace MediaBinBundle\Tests\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testIndex()
    {
        // User not loggued in (beta period)
        $client = static::createClient();
        $client->request('GET', '/MediaBin');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        // User loggued in without ROLE_BETA
        $client = $this->createRegularUserClient();
        $client->request('GET', '/MediaBin');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        // User loggued in with ROLE_BETA
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/MediaBin');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('MediaBin', $crawler->filter('h1')->text());
        $this->assertEquals('MediaInfo', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
        $this->assertEquals(
            'MediaBin',
            trim($crawler->filter('#main-navbar ul.nav li.active ul.menu_level_1 li.active a')->text())
        );
    }
}
