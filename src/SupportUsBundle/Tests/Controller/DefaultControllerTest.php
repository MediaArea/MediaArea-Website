<?php

namespace SupportUsBundle\Tests\Controller;

use UserBundle\Tests\Controller\UserAbstractControllerTest;

class DefaultControllerTest extends UserAbstractControllerTest
{
    public function testAbout()
    {
        // User not logged in
        $client = static::createClient();
        $client->request('GET', '/SupportUs');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // User logged in without ROLE_BETA
        $client = $this->createRegularUserClient();
        $client->request('GET', '/SupportUs');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // User logged in with ROLE_BETA
        $client = $this->createBetaUserClient();
        $crawler = $client->request('GET', '/SupportUs');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Support Us!', trim($crawler->filter('#main-navbar ul.nav li.active a')->text()));
    }

    public function testIndividual()
    {
        $client = static::createClient();
        $client->request('GET', '/SupportUs/Individual');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCorporate()
    {
        $client = static::createClient();
        $client->request('GET', '/SupportUs/Corporate');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFaq()
    {
        $client = static::createClient();
        $client->request('GET', '/SupportUs/FAQ');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSponsorsList()
    {
        $client = static::createClient();
        $client->request('GET', '/SupportUs/Sponsors');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSupportersList()
    {
        $client = static::createClient();
        $client->request('GET', '/SupportUs/Supporters');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
